<?php

namespace App\Http\Controllers\ToJson;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Commitments;
use Carbon\Carbon;
use App\TransactionLogs;
use Spatie\QueryBuilder\QueryBuilder;
use App\Lookups;
use App\SavingLogs;
use App\User;

class ToJsonController extends Controller
{
    public function commitmentList(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:commitments,id'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $getCommitment = Commitments::where('user_id', Auth::user()->id)->findOrFail($request->id);
        return response()->json($getCommitment);
    }

    public function overviewDashboard(){
        $totalDay = Carbon::now()->daysInMonth;
        $day = [];
        $income = [];
        $expenses = [];
        for($i = 1; $i <= $totalDay; $i++){
            if($i <= Carbon::now()->day){
                $logIncome = QueryBuilder::for(
                    TransactionLogs::with('lookup')
                        ->wherehas('lookup', function($query){
                            $query->where('master', 2);
                        })
                )->whereDay('created_at', $i)->whereMonth('created_at', Carbon::now()->month)->where('user_id', Auth::user()->id)->sum('log_rm');
        
                $logExpenses = QueryBuilder::for(
                    TransactionLogs::with('lookup')
                        ->wherehas('lookup', function($query){
                            $query->where('master', 3);
                            $query->orWhere('id', 16); //commitment id
                        })
                )->whereDay('created_at', $i)->whereMonth('created_at', Carbon::now()->month)->where('user_id', Auth::user()->id)->sum('log_rm');
                array_push($day, $i . ' Day');
                array_push($income, $logIncome);
                array_push($expenses, $logExpenses);
            } else {
                continue;
            }
        }
        return response()->json(compact('day','income', 'expenses'));
    }

    public function graphTransactionYear(){

        $month = [];
        $income = [];
        $expenses = [];
        for($i = 1; $i <= 12; $i++){
            $logIncome = QueryBuilder::for(
                TransactionLogs::with('lookup')
                    ->wherehas('lookup', function($query){
                        $query->where('master', 2);
                    })
            )->whereMonth('created_at', $i)->whereYear('created_at', Carbon::now()->year)->where('user_id', Auth::user()->id)->sum('log_rm');

            $logExpenses = QueryBuilder::for(
                TransactionLogs::with('lookup')
                    ->wherehas('lookup', function($query){
                        $query->where('master', 3);
                        $query->orWhere('id', 16); //commitment id
                    })
            )->whereMonth('created_at', $i)->whereYear('created_at', Carbon::now()->year)->where('user_id', Auth::user()->id)->sum('log_rm');

            array_push($month, date("F", mktime(0, 0, 0, $i, 1)));
            array_push($income, $logIncome);
            array_push($expenses, $logExpenses);
        }

        return response()->json(compact('month', 'income', 'expenses'));

    }

    public function chartIncomeDetail(){
        $incomeList = Lookups::ByIncomeList()->get()->toArray();
        $value = [];
        $label = [];
        foreach($incomeList as $income){
            $logIncome = QueryBuilder::for(
                TransactionLogs::with('lookup')
                    ->wherehas('lookup', function($query) use ($income){
                        $query->where('id', $income['id']);
                    })
            )->whereYear('created_at', Carbon::now()->year)->where('user_id', Auth::user()->id)->sum('log_rm');

            array_push($label, $income['title']);
            array_push($value, $logIncome);
        }

        return response()->json(compact('label', 'value'));
    }

    public function chartExpensesDetail(){
        $incomeList = Lookups::ByExpensesList()->get()->toArray();
        $value = [];
        $label = [];
        foreach($incomeList as $income){
            $logIncome = QueryBuilder::for(
                TransactionLogs::with('lookup')
                    ->wherehas('lookup', function($query) use ($income){
                        $query->where('id', $income['id']);
                    })
            )->whereYear('created_at', Carbon::now()->year)->where('user_id', Auth::user()->id)->sum('log_rm');

            array_push($label, $income['title']);
            array_push($value, $logIncome);
        }

        $logCommitment = QueryBuilder::for(
            TransactionLogs::with('lookup')
                ->wherehas('lookup', function($query) use ($income){
                    $query->where('id', 16);
                })
        )->whereYear('created_at', Carbon::now()->year)->where('user_id', Auth::user()->id)->sum('log_rm');
        array_push($label, 'Commitment');
        array_push($value, $logCommitment);

        return response()->json(compact('label', 'value'));
    }

    public function savingFlow(){
        $month = [];
        $savingIn = [];
        $savingOut = [];
        for($i = 1; $i <= 12; $i++){
            $logIn = SavingLogs::where('status', 1)->whereMonth('created_at', $i)->whereYear('created_at', Carbon::now()->year)->where('user_id', Auth::user()->id)->sum('log_rm');

            $logOut = SavingLogs::where('status', 2)->whereMonth('created_at', $i)->whereYear('created_at', Carbon::now()->year)->where('user_id', Auth::user()->id)->sum('log_rm');

            array_push($month, date("F", mktime(0, 0, 0, $i, 1)));
            array_push($savingIn, $logIn);
            array_push($savingOut, $logOut);
        }

        return response()->json(compact('month', 'savingIn', 'savingOut'));
    }

    public function savingAndMoney(){
        $user = User::with('userDetails')->find(Auth::user()->id);
        $label = ['Main Account','Saving Account', ];
        $saving = $user->userDetails->saving;
        $money = $user->userDetails->money;
        $value = [$money, $saving];
        return response()->json(compact('label','value'));
    }
}
