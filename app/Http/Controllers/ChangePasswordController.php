<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function updatePassword(Request $request)
    {

        try{
            $request->validate([
                'current_password' => ['required', new MatchOldPassword()],
                'new_password' => ['required'],
                'new_confirm_password' => ['same:new_password'],
            ]);
            User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
            return redirect()->back()->with('message', "Password Updated Successfully");
        }catch(QueryException $e){
            return redirect()->back();
        }
    }
}
