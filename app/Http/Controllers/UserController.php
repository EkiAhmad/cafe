<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user = User::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'password' => Hash::make($request->password)
         ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password')))
        {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('username', $request['username'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['message' => 'Hi '.$user->fullname.', welcome to home','access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }

    public function allUser(Request $request)
    {
        if ($request->id == null) {
            $data = User::where('is_deleted', 0)->latest()->paginate(10);
        } else {
            $data = User::where('is_deleted', 0)->where('id', $request->id)->get();
        }
        return [
            "status" => 1,
            "msg" => "Get Data Successfuly",
            "data" => $data
        ];
    }

    public function addUser(Request $request)
    {
        // echo "<pre>";
        // print_r(auth()->id());
        // echo "</pre>";
        // die();
        $validator = Validator::make($request->all(),[
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string',
            'email' => 'email',
            'role' => 'string'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user = User::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'role' => $request->role,
            'created_by' => auth()->id(),
         ]);
 
        return [
            "status" => 1,
            "msg" => "Add Data Successfuly",
            "data" => $user,
        ];
    }

    public function editUser(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string',
            'email' => 'email',
            'role' => 'string'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user = User::where('id', $request->id)->update([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'role' => $request->role,
            'updated_by' => auth()->id(),
         ]);
 
        return [
            "status" => 1,
            "msg" => "Update Data Successfuly",
            "data" => $user,
        ];
    }
 
    public function destroyUser(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user = User::where('id', $request->id)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => auth()->id(),
            'is_deleted' => 1,
         ]);
 
        return [
            "status" => 1,
            "msg" => "Deleted Data Successfuly",
            "data" => $user,
        ];
    }
}