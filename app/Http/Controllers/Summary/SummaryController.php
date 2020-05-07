<?php

namespace App\Http\Controllers\Summary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TransactionLogs;
use Spatie\QueryBuilder\QueryBuilder;
use Carbon\Carbon;
use Auth;
use App\User;

class SummaryController extends Controller
{
    public function index(){
        $user = User::with('userDetails')->find(Auth::user()->id);

        $thisYearIncome = QueryBuilder::for(
            TransactionLogs::with('lookup')
                ->wherehas('lookup', function($query){
                    $query->where('master', 2);
                })
        )->whereYear('created_at', Carbon::now()->year)->where('user_id', $user->id)->sum('log_rm');

        $thisYearExpenses = QueryBuilder::for(
            TransactionLogs::with('lookup')
                ->wherehas('lookup', function($query){
                    $query->where('master', 3);
                    $query->orWhere('id', 16); //commitment id
                })
        )->whereYear('created_at', Carbon::now()->year)->where('user_id', $user->id)->sum('log_rm');

        $allIncome = QueryBuilder::for(
            TransactionLogs::with('lookup')
                ->wherehas('lookup', function($query){
                    $query->where('master', 2);
                })
        )->where('user_id', $user->id)->sum('log_rm');

        $allExpenses = QueryBuilder::for(
            TransactionLogs::with('lookup')
                ->wherehas('lookup', function($query){
                    $query->where('master', 3);
                    $query->orWhere('id', 16); //commitment id
                })
        )->where('user_id', $user->id)->sum('log_rm');

        return view(
            'private_content.summary', 
            compact(
                'thisYearIncome', 
                'thisYearExpenses',
                'allIncome',
                'allExpenses'
            )
        );
    }

}
