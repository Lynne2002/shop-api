<?php
  namespace App\Http\Controllers;
  use Illuminate\Http\Request;
  use App\Models\User;
  use App\Http\Controllers\Controller;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\Hash;
  use Illuminate\Support\Facades\Validator;
  class UserController extends Controller
   {
       /**
       * CREATING NEW USER
       */
       public function createUser(Request $request){
         try{
           $validateUser = validator::make($request->all(),
             [
                 'name'=>'required',
                 'email'=> 'required|email|unique:users,email',
                 'password'=>'required'
              ]);
           if($validateUser->fails()){
               return response()->json([
               'status'=>false,
               'message'=>'Validation error',
               'errors'=>$validateUser->errors()
             ], 401);
           }
         $user = User::create([
             'name'=>$request->name,
             'email'=>$request->email,
             'password'=>Hash::make($request->password)
           ]);
        return response()->json([
             'status'=>true,
             'message'=>'User created successfully!',
             'token'=> $user->createToken("API TOKEN")->plainTextToken
          ], 200);
        } 
    catch(\Throwable $s){
         return response()->json([
           'status'=>false,
           'message'=>$s->getMessage()
            ], 500);
         }
       }
    /**
     * USER LOGIN
    */
   public function loginUser(Request $request){
     try{
       $validateUser = validator::make($request->all(),
       [
         'email'=>'required|email',
         'password'=>'required'
       ]);
      if($validateUser->fails()){
         return response()->json([
           'status'=>false,
           'message'=>'Validation error',
           'errors'=>$validateUser->errors()
       ], 401);
       }
      if(!Auth::attempt($request->only(['email', 'password']))){
             return response()->json([
               'status'=>false,
               'message'=>'Email or Password incorrect!'
              ], 401);
       }
     $user = User::where('email', $request->email)->first();
          return response()->json([
             'status'=>true,
             'message'=>'User logged in successfully',
             'token'=>$user->createToken("API TOKEN")->plainTextToken
           ],200);
         }
   catch(\Throwable $s){
       return response()->json([
         'status'=>false,
         'message'=>$s->getMessage()
       ], 500);
      }
   }
}
