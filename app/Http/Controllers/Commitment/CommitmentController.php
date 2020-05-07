<?php

namespace App\Http\Controllers\Commitment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Commitments;
use Validator;
use Alert;

class CommitmentController extends Controller
{

    public function index(){
        $getCommitment = Commitments::where('user_id', Auth::user()->id)->where('status', 1)->latest()->paginate(5);
        $getCommitmentComplete = Commitments::where('user_id', Auth::user()->id)->where('status', 2)->latest()->paginate(5);

        return view('private_content.commitment', compact('getCommitment', 'getCommitmentComplete'));
    }

    public function addCommitment(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'total' => 'required|numeric|min:0',
            'balance' => 'required|numeric|min:0',
            'monthly' => 'required|numeric|min:0.01',
            'limit' => 'required|numeric|min:0|max:1'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Ops, Missing something. Try Again');
            return redirect('/commitment');
        }

        if($request->limit == 0 && ($request->total - $request->balance) < 0){
            Alert::error('Error', 'Your Balance more than your Total Commitment');
            return redirect('/commitment');
        }

        $commitment = new Commitments;
        $commitment->user_id = Auth::user()->id;
        $commitment->title = $request->title;
        $commitment->total = $request->total;
        $commitment->balance = $request->balance;
        $commitment->monthly = $request->monthly;
        $commitment->status = 1;
        $commitment->unlimit = ($request->limit == 0) ? 0 : 1;

        if(!$commitment->save()){
            Alert::error('Error', 'You data cannot save. Try Again');
            return redirect('/commitment');
        }

        $commitmentTitle = strip_tags($commitment->title);

        Alert::success($commitmentTitle, "Commitment Added");
        return redirect('/commitment');

    }

    public function updateCommitment(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'total' => 'required|numeric|min:0',
            'balance' => 'required|numeric|min:0',
            'monthly' => 'required|numeric|min:0.01',
            'id' => 'required|integer|exists:commitments,id'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Someting Wrong. Try Again');
            return redirect('/commitment');
        }

        $commitment = Commitments::where('user_id', Auth::user()->id)->findOrFail($request->id);
        $commitment->title = $request->title;
        $commitment->total = $request->total;
        $commitment->balance = $request->balance;
        $commitment->monthly = $request->monthly;

        if(!$commitment->save()){
            Alert::error('Error', 'Cannot save your data. Please try again');
            return redirect('/commitment');
        }

        $commitmentTitle = strip_tags($commitment->title);
        Alert::success($commitmentTitle, 'Commitment Updated');
        return redirect('/commitment');

    }

    public function deleteCommitment(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:commitments,id'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Someting Wrong. Try Again');
            return redirect('/commitment');
        }

        $getCommitment = Commitments::where('user_id', Auth::user()->id)->findOrFail($request->id);
        if(!$getCommitment->delete()){
            Alert::error('Error', 'Cannot save your data. Please try again');
            return redirect('/commitment');
        }

        $commitmentTitle = strip_tags($commitment->title);
        Alert::success($commitmentTitle, 'Commitment Deleted');
        return redirect('/commitment');
    }

    public function forceCompleteCommitment(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:commitments,id'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Someting Wrong. Try Again');
            return redirect('/commitment');
        }

        $getCommitment = Commitments::where('user_id', Auth::user()->id)->findOrFail($request->id);
        $getCommitment->status = 2;
        if(!$getCommitment->save()){
            Alert::error('Error', 'Cannot save your data. Please try again');
            return redirect('/commitment');
        }

        $commitmentTitle = strip_tags($commitment->title);
        Alert::success($commitmentTitle, 'Commitment Force Complete');
        return redirect('/commitment');
    }
}
