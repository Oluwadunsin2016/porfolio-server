<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
  public function downloadPdf($token){
  $user = User::where('info_token', $token)->first();
  $filePath=storage_path('app/public/cv/'.$user->cv_URL);
  $fileName='my_cv.pdf';
  return response()->download($filePath, $fileName);
  }
}
