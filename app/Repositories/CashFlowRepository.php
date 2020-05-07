<?php

namespace App\Repositories;
use App\UserDetails;
use App\Commitments;

class CashFlowRepository{
    public function moneyTrigger($in = true, $amount){
        //if transaction in
        if($in){
            $money = UserDetails::find(\Auth::user()->userDetails()->first()->id);
            $money->money = $money->money + $amount;
            $money->save();
        //if transaction out
        } else {
            $money = UserDetails::find(\Auth::user()->userDetails()->first()->id);
            $money->money = $money->money - $amount;
            $money->save();
        }
    }
    public function savingTrigger($in = true, $amount){
        //if transaction in
        if($in){
            $money = UserDetails::find(\Auth::user()->userDetails()->first()->id);
            $money->saving = $money->saving + $amount;
            $money->save();
        //if transaction out
        } else {
            $money = UserDetails::find(\Auth::user()->userDetails()->first()->id);
            $money->saving = $money->saving - $amount;
            $money->save();
        }
    }

    public function commitmentTrigger($attributes){

            $commitment = Commitments::findOrFail($attributes->id);

            if($commitment->unlimit == 0){
                $commitment->status = ($commitment->balance - $attributes->total <= 0) ? 2 : 1 ;
                $commitment->balance = $commitment->balance - $attributes->total;
                $commitment->save();

                return $commitment->balance;
            } else {
                $commitment->total = $commitment->total + $attributes->total;
                $commitment->save();
                
                return -1;
            }
            
        

        
    }
}