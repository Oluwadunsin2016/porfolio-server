<?php
namespace App\Http\Controllers;
// require './vendor/autoload.php';

use App\Models\Project;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function storeProject(Request $request){
    $user=$request->user();
    
    $projects=json_decode($request->input('projects'), true);
    $existedProjects=Project::where('user_token',$user->info_token)->get();
    foreach ($projects as $project) {
   if (collect($existedProjects)->where('title',$project['title'])->first()) {
    return response()->json(['message' => 'You have a project named '.$project['title'].' already', 'error' => true]);
   }else{
    if ($project['image']) {
   $url=Cloudinary::upload($project['image'],['folder'=>'ProjectImages'])->getSecurePath();
   }else{
   $url=null;
   }

        Project::create([
        'user_token'=>$user->info_token,
        'title'=>$project['title'],
        'category'=>$project['category'],
        'image'=>$url,
        'web_link'=>$project['web_link'],
        'github_link'=>$project['github_link'],
        'description'=>$project['description'],
        ]);
   }


    }

    
    return response()->json(['message' => 'Projects stored successfully', 'error' => false]);
    }


         //Getting user information
  public function getProjects($token)
  {
$information=Project::where('user_token',$token)->get();
if (!$information) {
   return response()->json(['message' =>'User has no project', 'error' => true]);
}
   return response()->json($information);
  }
         //Updating project information
  public function updateProject(Request $request)
  {
   $result = json_decode($request->input(['project']),true) ;
  $project=Project::where('id',$result['id'])->first();
    if (!$project) {
      return response()->json(['message' => 'project not found', 'error' => true], 404);
    }

       if ($project['image'] && strpos($result['image'], 'base64') !== false) {
            $path = parse_url($project['image'], PHP_URL_PATH);

    // Extract the filename from the path
    $filename = basename($path);

    // Perform a search query to retrieve the image's public ID
    $searchResponse = Cloudinary::search()->expression("filename:$filename")->execute();
    if ($searchResponse['total_count'] > 0) {
        $publicId = $searchResponse['resources'][0]['public_id'];

        // Delete the image using its public ID
      Cloudinary::destroy($publicId);
    }
    }

     if ($result['image'] && strpos($result['image'], 'base64') !== false) {
   $url=Cloudinary::upload($result['image'],['folder'=>'ProjectImages'])->getSecurePath();
   }else{
   $url=$result['image'];
   }

    Project::where('id',$result['id'])->update([
        'title'=>$result['title'],
        'category'=>$result['category'],
        'image'=>$url,
        'web_link'=>$result['web_link'],
        'github_link'=>$result['github_link'],
        'description'=>$result['description'],
        ]);
    return response()->json(['message' => 'Project information updated successfully', 'error' => false]);
  }
         //Deleting Project information
  public function deleteProject($id)
  {
  Project::where('id',$id)->delete();
   return response()->json(['message' => 'Project deleted successfully', 'error' => false]);
  }
}
