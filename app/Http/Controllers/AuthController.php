<?php

namespace App\Http\Controllers;

use App\Mail\ForgottenPassword;
use App\Mail\PortfolioMail;
use App\Mail\VerificationMail;
use App\Models\Language;
use App\Models\Project;
use App\Models\SocialInformation;
use App\Models\User;
use App\Models\WorkInformation;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isEmpty;

class AuthController extends Controller
{
  //Getting user information
  public function getUser(Request $request)
  {
    $user = $request->user();
    if (!$user) {
      return response()->json(['message' => 'User not found'], 404);
    }
    return response()->json($user, 201);
  }
  //Getting user information
  public function getCurrentUser($token)
  {
    $user = User::where('info_token', $token)->first();
    if (!$user) {
      return response()->json(['message' => 'User not found'], 404);
    }
    return response()->json($user, 201);
  }


  //Registering a new user
  public function register(Request $request)
  {
    $userExist = User::where('email', $request->email)->first();
    if ($userExist) {
      return response()->json(["message" => 'Account already exists','user'=>true], 200);
    }
   User::create([
      'firstName' => $request->firstName,
      'lastName' => $request->lastName,
      'email' => $request->email,
      'phone_number' => $request->phone_number,
      'address' => $request->address,
      'password' => bcrypt($request->password),
      'info_token' => Str::random(10),
      'remember_token' => Str::random(40),
    ]);
    $user = User::where('email', $request->email)->first();
$mail=new VerificationMail($user);
    $mail->from('alexisnathan888@gmail.com', 'Nathan');
    Mail::to($request->email)->send($mail);
    return response()->json(["message" => 'Registered successfully, go and verify your email address','error'=>false], 200);
  }

  // Verify user email
  public function verify($token)
  {
$user=User::where('remember_token',$token)->first();
if (!empty($user)) {
  $user->update([
      'email_verified_at' => date('Y-m-d H:i:s'),
      'remember_token' => Str::random(40),
    ]);
$mail=new PortfolioMail($user);
    $mail->from('alexisnathan888@gmail.com', 'Nathan');
    Mail::to($user->email)->send($mail);
    return response()->json(['message' => 'Your email has been successfully verified', 'error' => false]);
} else {
    return response()->json(['message' => 'Your email has already been verified', 'error' => true]);
  abort(404);
}

  }
  // Updating a user information
  public function updateUser(Request $request)
  {
    $user = $request->user();
    if (!$user) {
      return response()->json(['message' => 'User not found', 'error' => true], 404);
    }

   $user->update([
      'firstName' => $request->firstName,
      'lastName' => $request->lastName,
      'email' => $request->email,
      'phone_number' => $request->phone_number,
      'address' => $request->address,
    ]);
    return response()->json(['message' => 'User information updated successfully','user'=>$user, 'error' => false]);
  }

  // Signing in a user
 public function login(Request $request)
{
    $currentUser = User::where('email', $request->email)->first();
    if (!empty($currentUser)) {
        if ($currentUser->email_verified_at) {
            $credentials = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
            if (Auth::attempt($credentials)) {
    $user = $request->user();
                $token = $user->createToken('authToken')->plainTextToken;
                return response()->json(['message' => 'You are successfully logged in', 'error' => false, 'token' => $token]);
            } else {
                return response()->json(['message' => 'Invalid login credentials', 'error' => true], 401);
            }
        } else {
            return response()->json(['message' => 'Your email has not been verified', 'error' => true], 401);
        }
    } else {
            return response()->json(['message' => "You don't have an account", 'error' => true], 401);
    }
    
        // return response()->json(['message' => 'Got the user','user'=>$currentUser, 'error' => false]);
}


  // Loging out a user
  public function logout(Request $request)
  {
    $request->user()->tokens()->delete();
    return response()->json(['message' => 'Logged out']);
  }


  // Updating a user's profile picture
  public function updateProfileImage(Request $request)
  {
    $user = $request->user();
    if (!$user) {
      return response()->json(['message' => 'User not found', 'error' => true], 404);
    }

   // Ensure the directory exists
    $directory = storage_path('app/public/ProfileImages');
    if (!file_exists($directory)) {
        // Create the directory if it doesn't exist
        mkdir($directory, 0777, true);
    }

Cloudinary::upload($request['profileImage']('file')->getRealPath())->getSecurePath();

    if ($user->profileImage) {
      unlink(storage_path('app/public/ProfileImages/' . $user->profileImage));
    }
    $generated_name = time() . '.' . explode('/', explode(':', substr($request['profileImage'], 0, strpos($request['profileImage'], ';')))[1])[1];

    $manager = new ImageManager(new Driver());
    $manager->read($request['profileImage'])->save(storage_path('app/public/ProfileImages/' . $generated_name));
    $user->update([
      'profileImage' => $generated_name
    ]);
    return response()->json(['message' => 'Your profile picture updated successfully', 'user'=>$user, 'error' => false]);
  }

  //Updating a user's about information
  public function updateSelfDescription(Request $request)
  {
    $user = $request->user();
    if (!$user) {
      return response()->json(['message' => 'User not found', 'error' => true], 404);
    }

    $user->update([
      'self_description' => $request['selfDescription']
    ]);
    return response()->json(['message' => 'Description saved successfully', 'error' => false]);
  }


  // Updating a user's CV
  public function uploadCV(Request $request)
  {
    $user = $request->user();
    if (!$user) {
      return response()->json(['message' => 'User not found', 'error' => true], 404);
    }
    if ($user->cv_URL) {
      unlink(storage_path('app/public/cv/' . $user->cv_URL));
    }
    $generated_name = time() . '.' . $request->myCV->getClientOriginalExtension();
    $request->myCV->move(storage_path('app/public/cv/'), $generated_name);
    $user->update([
      'cv_URL' => $generated_name
    ]);
    return response()->json(['message' => 'Your CV updated successfully', 'error' => false]);
  }


  //Updating a user's password
  public function updatePassword(Request $request)
  {
    $user = $request->user();

    if (Hash::check($request['old_password'], $user->password)) {
      $user->update([
        'password' => Hash::make($request['new_password'])
      ]);
      return response()->json(['message' => 'Your password updated successfully', 'error' => false]);
    } else {
      return response()->json(['message' => 'Your current password is incorrect', 'error' => true]);
    }
  }


  //Updating a user's password
  public function deleteAccount(Request $request)
  {
    $user = $request->user();

    if (Hash::check($request['password'], $user->password)) {
    Project::where('user_token',$user->info_token)->delete();
    Language::where('user_token',$user->info_token)->delete();
    SocialInformation::where('user_token',$user->info_token)->delete();
    WorkInformation::where('user_token',$user->info_token)->delete();
    $user->tokens()->delete();
    $user->delete();
      return response()->json(['message' => 'Account deleted successfully', 'error' => false]);
    } else {
      return response()->json(['message' => 'Password is incorrect', 'error' => true]);
    }
  }

  //Sending the user's verification number
    public function forgottenPassword(Request $request)
    {
        // Validation and user existence check
        $validatedData = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

   if ($validatedData) {
         // Generate random number
        $randomNumber = mt_rand(1000, 9999);

        // we save it in the cache
       Cache::put('random_number_data', ['number' => $randomNumber, 'email' => $validatedData['email']], 300);

//Getting the owner of the email
$user=User::where('email',$validatedData['email'])->first();

        // Send email with random number
    $information=['name'=>$user->firstName, 'number'=>$randomNumber];
$mail=new ForgottenPassword($information);
    $mail->from('alexisnathan888@gmail.com', 'Nathan');
       Mail::to($validatedData['email'])->send($mail);

        return response()->json(['message' => 'Some codes have been sent to your email','error'=>false],200);
   } else {
        return response()->json(['message' => "You don't have an account",'error'=>true],404);
   }
   
    }

  //Verifying the user's code
    public function verifyCode(Request $request)
    {
        // Retrieving the saved data from the cache
       $cacheData = Cache::get('random_number_data');

   if ($cacheData !== null) {
$randomNumber = $cacheData['number'];
    $email = $cacheData['email'];
    Cache::put('email', $email, 3600);
    if ($randomNumber==$request['number']) {
        return response()->json(['message' => 'Your code has been verified','error'=>false],200);
    } else {
        return response()->json(['message' => "Your provided code doesn't match",'error'=>true],404);
    }
   } else {
        return response()->json(['message' => "Your code has expired",'error'=>true],404);
   }
   
    }


  //Verifying the user's code
    public function getNewPassword(Request $request)
    {
        // Retrieving the saved data from the cache
       $email = Cache::get('email');

        // Checking whether it has expired or not
   if ($email !== null) {
    $user = User::where('email', $email)->first();
    if (!empty($user)) {
        $user->update([
        'password' => Hash::make($request['password'])
      ]);
      return response()->json(['message' => 'Your password updated successfully', 'error' => false],200);
    } else {
        return response()->json(['message' => "You don't have an account",'error'=>true],404);
    }
   } else {
        return response()->json(['message' => "Your time elapsed in an hour",'error'=>true],404);
   }
   
    }


    public function createStorageLink(){
       try {
            // Run the storage:link command
            Artisan::call('storage:link');
            
            return response()->json(['message' => 'Storage link created successfully.']);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['error' => 'Failed to create storage link.', 'details' => $e->getMessage()], 500);
        }
    }

}
