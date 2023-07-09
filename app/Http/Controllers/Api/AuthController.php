<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
// use Tymon\JWTAuth\Contracts\Providers\Auth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login']]);
    // }

    // public function GetData()
    // {
    //     return 'sdfjlkdsjflk';
    // }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'phone' => 'required|digits:11',
            'password' => 'required|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        // $user = Customer::create([
        //     'name' => $request->get('name'),
        //     'phone' => $request->get('phone'),
        //     'address' => $request->get('address'),
        //     'username' => $request->get('phone'),
        //     'save_by' => $request->ip(),
        //     'updated_by' => $request->ip(),
        //     'ip_address' => $request->ip(),
        //     'password' => Hash::make($request->get('password')),
        // ]);
        $customer = new Customer();
        $code = 'C' . $this->generateCode('Customer');
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->username = $request->phone;
        $customer->address = $request->address;
        $customer->password = Hash::make($request->password);
        $customer->ip_address = $request->ip();
        $customer->code = $code;
        $customer->save_by = $request->ip();
        $customer->updated_by = $request->ip();
        $customer->save();

        $token = JWTAuth::fromUser($customer);

        return response()->json(compact('customer','token'),201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('phone', 'password');
    //   return $credentials->phone;
        if ($token = $this->guard('api')->attempt($credentials)) {
            // return "success";
            
           $customer = Customer::where('phone', $request->phone)->first();
            return response()->json([
                'token' => $this->respondWithToken($token),
                'customer' =>  $customer,
                'success' => "success"
            ], 200);
        }

        return response()->json(['error' => 'phone Or passowrd Incorrect']);
    }

    public function Token($user){
        $token = auth()->login($user);
        return response()->json([
            'token' => $this->respondWithToken($token),
            'success' => "success"
        ], 200);
    }
   
    public function me()
    {
        return response()->json($this->guard('api')->user());
    }

    public function logout()
    {
        $this->guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard('api')->factory()->getTTL() * 60
        ]);
    }

    
    public function guard()
    {
        return Auth::guard('api');
    }
}