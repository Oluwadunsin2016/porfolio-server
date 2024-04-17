<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
  public function storeLanguages(Request $request){
  $user=$request->user();
  $languages=$request->all();
  foreach ($languages as $language) { 
    $existed=Language::where('user_token',$user['info_token'])->get()->where('name',$language['name'])->first();
   if ($existed) {
   return response()->json(['message' => 'You already have '.$language['name'].' saved', 'error' => true]);
   }else{
  Language::create([
  'user_token'=>$user['info_token'],
  'name'=>$language['name'],
  'url'=>$language['url'],
  ]);
   }
  }
  return response()->json(['message' => 'Languages saved successfully', 'error' => false]);
  }

          //Getting social information
  public function getLanguages($token)
  {
$information=Language::where('user_token',$token)->get();
if (!$information) {
   return response()->json(['message' =>'User has no language information', 'error' => true]);
}
   return response()->json($information);
  }

          //Updating social information
  public function updateLanguage(Request $request)
  {
Language::where('id',$request['id'])->update([
        'name'=>$request['name'],
        'url'=>$request['url'],
        ]);
    return response()->json(['message' => 'Stack updated successfully', 'error' => false]);
  }

           //Deleting Stack information
  public function deleteLanguage($id)
  {
  Language::where('id',$id)->delete();
   return response()->json(['message' => 'Stack deleted successfully', 'error' => false]);
  }
}
