<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lookups;

class SettingController extends Controller
{
    public function index(){

        $incomeList = Lookups::ByIncomeList()->get();
        $expensesList = Lookups::ByExpensesList()->get();

        return view('private_content.setting', compact('incomeList', 'expensesList'));
    }
}
