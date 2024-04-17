<?php

namespace App\Http\Controllers;

use App\Models\ExpertiseInformation;
use Illuminate\Http\Request;

class ExpertiseInformationController extends Controller
{
     public function storeExpertiseInformation(Request $request){
   $user=$request->user();
   $existed=ExpertiseInformation::where('user_token',$user['info_token'])->first();
   if (!$existed) {
   ExpertiseInformation::create([ 
   'user_token'=>$user['info_token'],
   'year_of_experience'=>$request['year_of_experience'],
   'number_of_clients'=>$request['number_of_clients'],
   'number_of_projects'=>$request['number_of_projects'],
  ]
   );
   return response()->json(['message' => 'Expertise information successfully', 'error' => false]);
   }else{
   return response()->json(['message' => 'You already have expertise information, you can only go and update', 'error' => true]);
   }
   }

     //Getting expertise information
  public function getExpertiseInformation($token)
  {
$expertise=ExpertiseInformation::where('user_token',$token)->first();
if (!$expertise) {
   return response()->json(['message' =>'User has no expertise expertise', 'error' => true]);
}
   return response()->json($expertise);
  }



     public function updateExpertiseInformation(Request $request){
   ExpertiseInformation::where('id',$request['id'])->update([
   'year_of_experience'=>$request['year_of_experience'],
   'number_of_clients'=>$request['number_of_clients'],
   'number_of_projects'=>$request['number_of_projects'],
  ]
   );
   return response()->json(['message' => 'Work expertise updated successfully', 'error' => false]);
   }
}
