<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->validate(
            [
                'name'       =>     'required|max:100',
                'email'      =>     'required|email:rfc,dns',
                'password'   =>     'required|string',
                'phone'      =>     'required',
                'account_id' =>     'required|integer',
                ]
            );
        $user = new User();
        $user->name = $request->get( 'name' );
        $user->email = $request->get( 'email' );
        $user->password = Hash::make($request->get( 'password' ));
        $user->phone = $request->get( 'phone' );
        $user->account_id = $request->get( 'account_id' );
        $user->save();

        return $user;
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
                'email' => 'required',
                'password' => 'required',
            ]
        );
        $cropt = $req->only( 'email','password' );

        if( auth()->attempt( $cropt ) ){
            $user = User::where( 'email', $req->get( 'email' ) )->first();
            return [ 'api_token' => $user->api_token ];
            
            // return ;
        }
        return "new UserResource( );";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
