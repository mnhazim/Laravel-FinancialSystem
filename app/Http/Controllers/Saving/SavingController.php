<?php

namespace App\Http\Controllers\Saving;

use Alert;
use App\Http\Controllers\Controller;
use App\Repositories\CashFlowRepository;
use App\SavingLogs;
use App\TransactionLogs;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;

class SavingController extends Controller
{
    private $cashFlowRepository;

    public function __construct(CashFlowRepository $cashFlowRepository)
    {

        $this->cashFlowRepository = $cashFlowRepository;

    }

    public function index()
    {
        $user = User::with('userDetails')->find(Auth::user()->id);

        if ($user->userDetails == null) {
            Alert::success('Welcome', "For the first time, you need to update your current money. Click 'Edit Page'");
            return redirect('/profile');
        }

        $latestTransaction = SavingLogs::where('user_id', $user->id)->get();
        $logIn = SavingLogs::where('status', 1)->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->where('user_id', Auth::user()->id)->sum('log_rm');
        $logOut = SavingLogs::where('status', 2)->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->where('user_id', Auth::user()->id)->sum('log_rm');

        return view('private_content.saving', compact('user', 'latestTransaction', 'logIn', 'logOut'));
    }

    public function savingIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string',
            'total' => 'required|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Someting Wrong. Try Again');
            return redirect('/saving');
        }

        $user = User::with('userDetails')->find(Auth::user()->id);
        if ($request->total > $user->userDetails->money) {
            Alert::error('Error', 'Your main account not enough money');
            return redirect('/saving');
        }

        $saving = new SavingLogs;
        $saving->user_id = Auth::user()->id;
        $saving->log_reason = $request->reason;
        $saving->log_rm = $request->total;
        $saving->status = 1; //1 for in, 2 for out

        if (!$saving->save()) {
            Alert::error('Error', 'Saving Cannot Proceed. Try Again');
            return redirect('/saving');
        }

        $transaction = new TransactionLogs;
        $transaction->user_id = Auth::user()->id;
        $transaction->log_reason = $request->reason;
        $transaction->log_rm = $request->total;
        $transaction->kategori_id = 6;

        if (!$transaction->save()) {
            Alert::error('Error', 'Transaction Cannot Proceed. Try Again');
            return redirect('/saving');
        }

        $this->cashFlowRepository->moneyTrigger(false, $request->total);
        $this->cashFlowRepository->savingTrigger(true, $request->total);
        Alert::success('Success', "Transaction Success transfer to Saving Account");
        return redirect('/saving');

    }

    public function savingOut(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string',
            'total' => 'required|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Someting Wrong. Try Again');
            return redirect('/saving');
        }

        $user = User::with('userDetails')->find(Auth::user()->id);
        if ($request->total > $user->userDetails->saving) {
            Alert::error('Error', 'Your main account not enough money');
            return redirect('/saving');
        }

        $saving = new SavingLogs;
        $saving->user_id = Auth::user()->id;
        $saving->log_reason = $request->reason;
        $saving->log_rm = $request->total;
        $saving->status = 2; //1 for in, 2 for out

        if (!$saving->save()) {
            Alert::error('Error', 'Saving Cannot Proceed. Try Again');
            return redirect('/saving');
        }

        $transaction = new TransactionLogs;
        $transaction->user_id = Auth::user()->id;
        $transaction->log_reason = $request->reason;
        $transaction->log_rm = $request->total;
        $transaction->kategori_id = 17;

        if (!$transaction->save()) {
            Alert::error('Error', 'Transaction Cannot Proceed. Try Again');
            return redirect('/saving');
        }

        $this->cashFlowRepository->moneyTrigger(true, $request->total);
        $this->cashFlowRepository->savingTrigger(false, $request->total);
        Alert::success('Success', "Transaction Success transfer to Main Account");
        return redirect('/saving');
    }
}
