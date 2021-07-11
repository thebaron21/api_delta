<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function index(Request $req)
    {
        $user = $req->user();

        return  toJsonModel($user);
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

            return toJsonModel($user);
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
        return toJsonModel($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
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
        return toJsonModel($user);
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
        return toJsonModel($user);
    }
}
