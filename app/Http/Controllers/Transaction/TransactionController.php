<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\TransactionLogs;
use App\Repositories\CashFlowRepository;
use Illuminate\Support\Facades\Session;
use App\Commitments;
use Alert;
use Validator;

class TransactionController extends Controller
{
    private $cashFlowRepository;

    public function __construct(CashFlowRepository $cashFlowRepository){

        $this->cashFlowRepository = $cashFlowRepository;

    }

    public function index(){
        $getTransaction = TransactionLogs::with('lookup')->where('user_id', Auth::user()->id)->latest()->paginate(10);
        
        return view('private_content.transaction', compact('getTransaction'));
    }

    public function transactionIn(Request $request){

        $validator = Validator::make($request->all(), [
            'reason' => 'required|string',
            'total' => 'required|numeric|min:0.01',
            'kategori_id' => 'required|integer|exists:lookups,id'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Someting Wrong. Try Again');
            return redirect('/');
        }

        $transaction = new TransactionLogs;
        $transaction->user_id = Auth::user()->id;
        $transaction->log_reason = $request->reason;
        $transaction->log_rm = $request->total;
        $transaction->kategori_id = $request->kategori_id;

        if(!$transaction->save()){
            Alert::error('Error', 'Transaction Cannot Proceed. Try Again');
            return redirect('/');
        }

        $this->cashFlowRepository->moneyTrigger(true, $request->total);
        $transactionReason = strip_tags($transaction->log_reason);
        Alert::success($transactionReason, "Transaction Success");
        return redirect('/');
    }

    public function transactionOut(Request $request){

        $validator = Validator::make($request->all(), [
            'reason' => 'required|string',
            'total' => 'required|numeric|min:0.01',
            'kategori_id' => 'required|integer|exists:lookups,id'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Someting Wrong. Try Again');
            return redirect('/');
        }

        $transaction = new TransactionLogs;
        $transaction->user_id = Auth::user()->id;
        $transaction->log_reason = $request->reason;
        $transaction->log_rm = $request->total;
        $transaction->kategori_id = $request->kategori_id;

        if(!$transaction->save()){
            Alert::error('Error', 'Transaction Cannot Proceed. Try Again');
            return redirect('/');
        }

        $this->cashFlowRepository->moneyTrigger(false, $request->total);
        $transactionReason = strip_tags($transaction->log_reason);
        Alert::success($transactionReason, "Transaction Success");
        return redirect('/');
    }

    public function transactionOutByCommitment(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'total' => 'required|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Someting Wrong. Try Again');
            return redirect('/');
        }

        $commitment = Commitments::findOrFail($request->id);
        
        if($commitment->unlimit == 0){
            $checkBalance = $commitment->balance - $request->total;

            //if got negative
            if($checkBalance < 0){
                Alert::error('Error', 'Your amount will get negative. please make sure your pay fix amount');
                return redirect('/');
            }
        }
        
        $transaction = new TransactionLogs;
        $transaction->user_id = Auth::user()->id;
        $transaction->log_reason = $commitment->title;
        $transaction->log_rm = $request->total;
        $transaction->kategori_id = 16;

        if(!$transaction->save()){
            Alert::error('Error', 'Transaction Cannot Proceed. Try Again');
            return redirect('/');
        }

        $balance = $this->cashFlowRepository->commitmentTrigger($request);
        $this->cashFlowRepository->moneyTrigger(false, $request->total);

        if($balance >= 0){
            $message = ($balance <= 0) ? 'Commitment Completed.' : 'Your Balance RM ' . $balance; 
        } else {
            $message = 'Dont Pay for RM ' . $request->total;
        }

        $commitmentTitle = strip_tags($commitment->title);
        Alert::success($commitmentTitle, $message);
        return redirect('/');
    }
}
