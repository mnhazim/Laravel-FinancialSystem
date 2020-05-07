<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    //dashboard
    Route::get('/', 'Dashboard\DashboardController@index');

    //profile
    Route::get('/profile', 'Profile\ProfileController@index');
    Route::post('/editProfile', 'Profile\ProfileController@editProfile')->name('editProfile');
    Route::post('/editPassword', 'Profile\ProfileController@resetPassowrd')->name('resetPassword');

    //commitment
    Route::get('/commitment', 'Commitment\CommitmentController@index');
    Route::post('/addCommitment', 'Commitment\CommitmentController@addCommitment')->name('addCommitment');
    Route::post('/updateCommitment', 'Commitment\CommitmentController@updateCommitment')->name('updateCommitment');
    Route::post('/deleteCommitment', 'Commitment\CommitmentController@deleteCommitment');
    Route::post('/forceCompleteCommitment', 'Commitment\CommitmentController@forceCompleteCommitment');

    //transaction
    Route::get('/transaction', 'Transaction\TransactionController@index');
    Route::post('/transactionIn', 'Transaction\TransactionController@transactionIn');
    Route::post('/transactionOut', 'Transaction\TransactionController@transactionOut');
    Route::post('/transactionOutByCommitment', 'Transaction\TransactionController@transactionOutByCommitment');
    
    //Saving
    Route::get('/saving', 'Saving\SavingController@index');
    Route::post('/savingIn', 'Saving\SavingController@savingIn');
    Route::post('/savingOut', 'Saving\SavingController@savingOut');

    //Setting
    Route::get('/setting', 'Setting\SettingController@index');

    //summary
    Route::get('/summary', 'Summary\SummaryController@index');

    //toJson
    Route::post('/tojson/commitmentList', 'ToJson\ToJsonController@commitmentList');
    Route::get('/tojson/overviewDashboard', 'ToJson\ToJsonController@overviewDashboard');
    Route::get('/tojson/graphTransactionYear', 'ToJson\ToJsonController@graphTransactionYear');
    Route::get('/tojson/chartIncomeDetail', 'ToJson\ToJsonController@chartIncomeDetail');
    Route::get('/tojson/chartExpensesDetail', 'ToJson\ToJsonController@chartExpensesDetail');
    Route::get('/tojson/savingFlow', 'ToJson\ToJsonController@savingFlow');
    Route::get('/tojson/savingAndMoney', 'ToJson\ToJsonController@savingAndMoney');

    

    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
});
