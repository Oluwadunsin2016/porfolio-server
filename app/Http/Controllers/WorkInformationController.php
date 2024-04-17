<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WorkInformation;
use Illuminate\Http\Request;

class WorkInformationController extends Controller
{
   public function storeWorkInformation(Request $request){
   $user=$request->user();
   $specializations=$request->all();
  foreach ($specializations as $specialization) { 
  WorkInformation::create([
  'user_token'=>$user['info_token'],
  'profession'=>$specialization['profession'],
  'professional'=>$specialization['professional'],
  ]);
  }
   return response()->json(['message' => 'Work information successfully', 'error' => false]);
   }

     //Getting work information
  public function getWorkInformation($token)
  {
$information=WorkInformation::where('user_token',$token)->get();
if (!$information) {
   return response()->json(['message' =>'User has no work information', 'error' => true]);
}
   return response()->json($information);
  }
}
