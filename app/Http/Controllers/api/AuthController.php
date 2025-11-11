<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\api\ApiResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function register(Request $request)
    {
        // dd($request->userAgent());
        // Validate user registration data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            // 'device_name' => 'string|min:6',
        ]);
        // $errors = $validator->errors();
        // $errorMessages = $errors->all();
        // $errorMessages = $validator->errors()->all();

        // // دمج الأخطاء إلى نص واحد بفصلها بفاصلة
        // $errorText = implode(', ', $errorMessages);

        // if ($validator->fails()) {
        //     return $this->apiResponse('', $errorText , 422);
        // }
        if ($validator->fails()) {
            return response()->json(['errors' => $this->error_processor($validator)], 422);
        }

        $data = $request->except('image');
        if ($request->image) {
            $data['image'] = $this->uploadImage($request);
        } else {
            $data['image'] = "";
        }

        // // إنشاء مستخدم جديد
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->verification_code = $request->code;
        $user->image = $data['image'];
        $user->type = "user";
        $user->save();


        // Generate a token for the new user
        $device_name = $request->input('device_name', $request->userAgent());
        $token = $user->createToken($device_name)->plainTextToken;

        return $this->apiResponse(
            [
                'code' => 1,
                'user' => $user,
                'access_token' => $token,
            ],
            'ok', 201);
    }


    public function login(Request $request)
    {

        // Validate user login data
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if ($validator->fails()) {
            return response()->json(['errors' => $this->error_processor($validator)], 422);
        }
        // }
        // Attempt to authenticate the user
        // $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // $device_name = $request->input('device_name', $request->userAgent());
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->apiResponse([
                'code' => 1,
                'user' => $user,
                'access_token' => $token,
            ],
             'ok', 200);

        }

        return $this->apiResponse([
            'code' => 0,
            'message' => 'Invalid credentials',
        ],
         'The Email and Password is error', 401);
    }


    public function logOut(Request $request)
      {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);


    }

    public static function error_processor($validator)
    {
        $err_keeper = [];
        foreach ($validator->errors()->getMessages() as $index => $error) {
            array_push($err_keeper, ['code' => $index, 'message' => $error[0]]);
        }
        return $err_keeper;
    }

}
