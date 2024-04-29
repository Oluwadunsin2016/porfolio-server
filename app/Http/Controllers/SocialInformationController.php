<?php

namespace App\Http\Controllers;

use App\Models\SocialInformation;
use Illuminate\Http\Request;

class SocialInformationController extends Controller
{
   public function storeSocialInformation(Request $request){
   $user=$request->user();
   SocialInformation::create([
   'user_token'=>$user['info_token'],
   'whatsapp'=>$request['whatsapp'],
   'facebook'=>$request['facebook'],
   'instagram'=>$request['instagram'],
   'twitter'=>$request['twitter'],
   'linkedin'=>$request['linkedin'],
   'telegram'=>$request['telegram'],
   ]);
   return response()->json(['message' => 'Social information saved successfully', 'error' => false]);
   }

        //Getting social information
  public function getSocialInformation($token)
  {
$information=SocialInformation::where('user_token',$token)->first();
if (!$information) {
   return response()->json(['message' =>'User has no social information', 'error' => true]);
}
   return response()->json($information);
  }

// Updating social information
   public function updateSocialInformation(Request $request){
   $user=$request->user();
   $information=SocialInformation::where('user_token',$user['info_token'])->first();
   if ($information) {
    $information->update([
   'whatsapp'=>$request['whatsapp'],
   'facebook'=>$request['facebook'],
   'instagram'=>$request['instagram'],
   'twitter'=>$request['twitter'],
   'linkedin'=>$request['linkedin'],
   'telegram'=>$request['telegram'],
   ]);
   return response()->json(['message' => 'Social information updated successfully', 'error' => false]);
   } else {
   return response()->json(['message' => "You don't have any social information saved already", 'error' => true]);
   }
   
   }
}
