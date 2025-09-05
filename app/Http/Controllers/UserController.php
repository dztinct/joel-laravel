<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function singleUserData($user_id){
        try{
            $user_data = User::where('id', $user_id)->with(['products'])->get();
            return response()->json(['message' => $user_data], 200);
        } catch (Exception $e) {
            Log::error(['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    
    public function allUserData(){
        try{
            $user_data = User::with(['products'])->get();
            return response()->json(['message' => $user_data], 200);
        } catch (Exception $e) {
            Log::error(['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
