<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class DownloadController extends Controller
{
  public function downloadPdf($token){
  $user = User::where('info_token', $token)->first();
  $filePath=$user->cv_URL;
  $filename='my_cv.pdf';


 if (!$filePath) {
      return response()->json(['message' => 'The user has no CV yet', 'error' => true], 404);
    }
     // Fetch the PDF file content from the Cloudinary URL
    $response = Http::get($filePath);

    // Check if the response is successful
    if (!$response->successful()) {
        abort(500, 'Failed to fetch PDF file from Cloudinary');
    }

    // Set the appropriate headers for the file download
    // return response($response->body())
    //     ->header('Content-Type', 'application/pdf')
    //     ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    $headers = [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="my_cv.pdf"',
    ];
return Response::make($response->body(), 200, $headers);
  }
}
