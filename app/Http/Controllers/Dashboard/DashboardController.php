<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Lookups;
use Auth;
use Validator;
use App\TransactionLogs;
use Illuminate\Support\Facades\Session;
use App\Commitments;
use App\User;
use Carbon\Carbon;
use Alert;

class DashboardController extends Controller
{
    
    public function index(){
        $user = User::with('userDetails')->find(\Auth::user()->id);

        if($user->userDetails == null){
            Alert::success('Welcome', "For the first time, you need to update your current money. Click 'Edit Page'");
            return redirect('/profile');
        }

        $incomeList = Lookups::ByIncomeList()->get();
        $expensesList = Lookups::ByExpensesList()->get();


        $latestTransaction = TransactionLogs::with('lookup')->LatestTransaction(5)->get();
        $lastUpdateTransaction = TransactionLogs::with('lookup')->LatestTransaction(1)->first();
        $thisMonthIncome = QueryBuilder::for(
            TransactionLogs::with('lookup')
                ->wherehas('lookup', function($query){
                    $query->where('master', 2);
                })
        )->whereMonth('created_at', Carbon::now()->month)->where('user_id', $user->id)->sum('log_rm');

        $thisMonthExpenses = QueryBuilder::for(
            TransactionLogs::with('lookup')
                ->wherehas('lookup', function($query){
                    $query->where('master', 3);
                    $query->orWhere('id', 16); //commitment id
                })
        )->whereMonth('created_at', Carbon::now()->month)->where('user_id', $user->id)->sum('log_rm');

        if($thisMonthExpenses <= 0 || $thisMonthIncome <= 0){
            $percentageIncome = "--";
            $percentageExpenses = "--";
        } else {
            $step1 = $thisMonthIncome - $thisMonthExpenses;
            $step2 = ($step1 < 0) ? $thisMonthIncome / $thisMonthExpenses : $thisMonthExpenses / $thisMonthIncome;
            $step3 = number_format(($step1 < 0) ? ($step2 * 100) - 100 : $step2 * 100 ,2);
            $step4 = number_format(($step1 < 0) ? 100 - ( $step3) : 100 - $step3,2);
            $percentageExpenses = ($step1 < 0) ? $step4 : $step3 ;
            $percentageIncome = ($step1 < 0) ? $step3 : $step4 ;
        }
       

        $getSumMonthly = Commitments::where('user_id', Auth::user()->id)->where('status', 1)->SumMonthly();
        $getCommitment = Commitments::where('user_id', Auth::user()->id)->where('status', 1)->get();

        return view(
            'private_content.index', 
            compact(
                'user', 
                'incomeList', 
                'expensesList', 
                'latestTransaction',
                'lastUpdateTransaction',
                'thisMonthIncome',
                'thisMonthExpenses',
                'getSumMonthly',
                'getCommitment',
                'percentageExpenses',
                'percentageIncome'
            )
        );
    }

}
