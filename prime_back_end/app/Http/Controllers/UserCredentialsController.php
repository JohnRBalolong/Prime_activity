<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserCredentials;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class UserCredentialsController extends Controller
{
    // public function index(){
    //     $user = UserCredentials::all();
        
    //  if($user ->count() > 0){
    //      $data =[ 
    //          'status' => 200,
    //          'userdata' => $user
     
    //          ];
 
    //      return response()->json($data, 200);
         
 
    //  }else{
    //      return response()->json([
    //          'status' => 404,
    //          'message' => 'No user registerd'
    //      ], 404);
    //  }
   
    //  }



     public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'last_name' => 'required|string|max:191',
        'first_name' => 'required|string|max:191',
        'suffix' => 'nullable|string|max:191',
        'email_address' => 'required|email|unique:user_accounts,email_address',
        'username' => 'required|string|unique:user_accounts,username|max:191',
        'password' => 'required|string|min:8',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 422,
            'error' => $validator->messages(),
        ], 422);
    } else {
        $userCredentials = new UserCredentials();
        $userCredentials->last_name = $request->input('last_name');
        $userCredentials->first_name = $request->input('first_name');
        $userCredentials->suffix = $request->input('suffix');
        $userCredentials->email_address = $request->input('email_address');
        $userCredentials->username = $request->input('username');
        $userCredentials->password = bcrypt($request->input('password'));
        $userCredentials->save();

        return response()->json([
            'status' => 200,
            'message' => 'Your data is secure with us!',
        ], 200);
    }
    
}

public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'username' => 'required|string|max:191',
        'password' => 'required|string|min:8',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 422,
            'error' => $validator->messages(),
        ], 422);
    } else {
        $user = UserCredentials::where('username', $request->input('username'))->first();
        if ($user && Hash::check($request->input('password'), $user->password)) {
            $data = [
                'status' => 200,
                'user' => $user
            ];
            return response()->json($data, 200);
        } else {
            return response()->json([
                'status' => 401,
                'error' => 'Invalid username or password',
            ], 401);
        }
    }
}







    
}
