<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\UserDetails;
use Alert;
use Validator;
use Hash;

class ProfileController extends Controller
{
    public function index(){
        $user = User::with('userDetails')->find(Auth::user()->id);

        return view ('private_content.profile', compact('user'));
    }

    public function editProfile(Request $request){
        $user = User::with('userDetails')->find(Auth::user()->id);
        $indicator = true;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Name required');
            return redirect('/profile');
        }

        if($user->userDetails == null){
            $checkName = Validator::make($request->all(), [
                'money' => 'required|numeric|min:0',
            ]);

            if ($checkName->fails()) {
                Alert::error('Error', 'Something wrong, try again.');
                return redirect('/profile');
            }

            $userDetail = new UserDetails;
            $userDetail->user_id = Auth::user()->id;
            $userDetail->money = $request->money;
            if(!$userDetail->save()){
                Alert::error('Error', 'Cannot save your data. Please try again');
                return redirect('/profile');
            }
            $indicator = false;
            $money = strip_tags($request->money);
            Alert::success('Success', 'Your current money RM ' . $money . ' Saved');
        }

        $user->name = $request->name;
        if(!$user->save()){
            Alert::error('Error', 'Cannot save your data. Please try again');
            return redirect('/profile');
        }

        ($indicator) ? Alert::success('Success', 'Update Success') : '';
        return redirect('/');
    }

    public function resetPassowrd(Request $request){

        $validator = Validator::make($request->all(), [
            'currentpass' => 'required',
            'password' => 'required|min:8',
            'password_confirmation' => 'required_with:password|same:password|min:8'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Ops, Missing something. Try Again');
            return redirect('/profile');
        }

        $user = User::find(Auth::user()->id);
        $checkIsValid = Hash::check($request->currentpass, $user->password);
        
        if (!$checkIsValid) {
            Alert::error('Error', 'Ops, Your Current password is wrong. Try Again.');
            return redirect('/profile');
        }

        $user->password = Hash::make($request->password);
        if(!$user->save()){
            Alert::error('Error', 'Ops, Unsuccesfull save your password.');
            return redirect('/profile');
        }

        Alert::success('Successful', "Password Changed.");
        return redirect('/commitment');

    }
}
