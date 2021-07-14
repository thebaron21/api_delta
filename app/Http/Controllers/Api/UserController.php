<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\ForgotPassword;

class UserController extends Controller
{

    public function index(Request $req)
    {
        $user = $req->user();

        return  new JsonResponse($user,200);
    }


    public function create(Request $request)
    {
        $data = Validator::make(
            $request->all(),
            [
                'username'   =>     'required|max:100',
                'email'      =>     'required|email|unique:users',
                'password'   =>     'required|string',
                'phone'      =>     'required',
                'user_type' =>     'required|integer',
            ]
        );
        if ($data->fails()) {
            return toJsonErrorModel($data->errors()->all());
        } else {
            $user = new User();
            if ($request->has('lastname')) {
                $user->lastname = $request->get('lastname');
            }
            if ($request->has('gender')) {
                $user->gender = $request->get('gender');
            }
            if ($request->has('marital_status')) {
                $user->marital_status = $request->get('marital_status');
            }
            if ($request->has('birth_date')) {
                $user->birth_date = $request->get('birth_date');
            }
            if ($request->has('country')) {
                $user->country = $request->get('country');
            }
            if ($request->has('avatar')) {
                $f = uploadimg($request);
                $user->avatar = $f;
            }

            $user->username = $request->get('username');
            $user->email = $request->get('email');
            $user->password = Hash::make($request->get('password'));
            $user->phone = $request->get('phone');
            $user->user_type = $request->get('user_type');
            $user->save();
            $this->sendOtpUser($user);

            // pcntl_async_signals(true);
            

            return new JsonResponse($user,200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $req)
    {
        $req->validate(
            [
                'email' => 'required|email:rfc,dns',
                'password' => 'required',
            ]
        );
        $cropt = $req->only('email', 'password');

        if (auth()->attempt($cropt)) {
            $user = User::where('email', $req->get('email'))->first();
            return ['api_token ' => $user->api_token];

            // return ;
        }
        return toJsonErrorModel(auth()->attempt($cropt));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = User::all();
        return new JsonResponse($user,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = User::find($id);

        if ($request->has('lastname')) {
            $user->lastname = $request->get('lastname');
        }
        if ($request->has('firstname')) {
            $user->firstname = $request->get('firstname');
        }
        if ($request->has('gender')) {
            $user->gender = $request->get('gender');
        }
        if ($request->has('marital_status')) {
            $user->marital_status = $request->get('marital_status');
        }
        if ($request->has('birth_date')) {
            $user->birth_date = $request->get('birth_date');
        }
        if ($request->has('country')) {
            $user->country = $request->get('country');
        }
        if ($request->hasFile('avatar')) {
            $file = uploadimg($request);
            $user->avatar = $file;
        }
        if ($request->has('username')) {
            $user->username = $request->get('username');
        }
        if ($request->has('password')) {
            $user->password = Hash::make($request->get('password'));
        }
        if ($request->has('phone')) {
            $user->phone = $request->get('phone');
        }
        if ($request->has('user_type')) {
            $user->user_type = $request->get('user_type');
        }

        $user->save();
        return new JsonResponse($user,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return new JsonResponse($user,200);
    }
    public function emailVerified(Request $request)
    {
        $data = Validator::make(
            $request->all(),
            [
                "otp" => "required|integer"
            ]
        );
        if ($data->fails()) {
            return toJsonErrorModel($data->errors()->all());
        } else {
            $id = $request->user()->id;
            $user = User::find($id);
            
            if( $request->otp == $user->otp ){
                $user->email_verified =  1;
                $user->save();
                return new JsonResponse(
                    [
                        "Email" => "Verified"
                    ],200
                );
            }else{
                return new JsonResponse(
                    [
                        "otp" => "not accept"
                    ],200
                );
            }
        }
    }

    public function sendOtp(Request $req)
    {
        $user = $req->user();
        $user1 = User::find($user->id);
        $user1->otp = rand(1111,9999);
        $user1->save();
        sendOTP($user1->email,$user1->username,$user1->otp);
        
        return new JsonResponse([
            "OTP" => "SuccessFully",
            "Email" => $user1->email,
            "OTP"   => $user1->otp
        ],200);
    }

    private function sendOtpUser(User $user)
    {
        sendOTP($user->email,$user->username,$user->otp);
        
        return new JsonResponse([
            "OTP" => "SuccessFully",
            "Email" => $user->email,
            "OTP"   => $user->otp
        ],200);
    }
    /// Forgot Password

    public function forgot_password(Request $request)
    {
        $data = Validator::make($request->all(),[
            "email" => "required|email"
        ]);
        if($data->fails()){
            return new JsonResponse($data->errors()->all(),422);
        }else{
            $reset = new ForgotPassword;
            $user = User::where( "email",$request->email )->first();
            if($user != null){
                $reset->user_id = $user->id;
                $reset->code    = rand(1111,9999);
                $reset->save();
                sendOTP($user->email,$user->username,$reset->code);
                return new JsonResponse($reset,200);
            }else{
                return new JsonResponse(["email" => "error"],422);
            }
        }
    }

    public function reset(Request $req)
    {
        $data = Validator::make($req->all(),[
            'email'  => 'required',
            'password'  => 'required',
            'otp'       => 'required'
        ]);
        if($data->fails()){
            return new JsonResponse($data->errors()->all(), 422);
        }else{
            $user  = User::where( "email",$req->email )->first();
            if($user != null){
                $reset = ForgotPassword::where( "user_id",$user->id )->first();
                if (intval($req->otp) == intval($reset->code)) {
                    $user->password = Hash::make($req->password);
                    $user->save();
                    $reset->delete();
                    return new JsonResponse(["otp" => "ok"],200);
                }else{
                    return new JsonResponse(["otp" => "error"],422);
                }
            }else{
                return new JsonResponse(["email" => "error"],422);
            }
        }
    }
}
