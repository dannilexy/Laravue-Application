<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use Image;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|max:191|email|unique:users',
            'password' => 'required|string|min:6'
        ]);
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user-> type = $request->input('type');
            $user->bio = $request->input('bio');
            $user->photo = $request->input('photo');
            $user->password = bcrypt($request->input('name'));
            $user->save();
              return response()->json($user, 201);

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



    public function profile()
    {
        return \auth('api')->user();
    }


    public function change(Request $request){
       $user = auth('api')->user();

       $this->validate($request, [
        'name' => 'required|string|max:191',
        'email' => 'required|string|max:191|email|unique:users,email,'.$user->id,
        'password' => 'sometimes|min:6'
        ]);

        $currentPhoto = $user->photo;

       if( $request-> photo != $currentPhoto){
        $name = \time().'.'.explode('/', \explode(':', \substr( $request-> photo, 0, \stripos( $request-> photo, ';')))[1])[1];
        Image::make($request-> photo)->save(\public_path('image/profile/').$name);

        // $request->photo = $name;
        $request->merge(['photo' => $name]);

        $userPhoto = \public_path('image/profile/').$currentPhoto;

        if(\file_exists( $userPhoto )){
            @\unlink( $userPhoto );
        }
        }


        if(!empty($request->photo)){
            $request->merge(['password' => bcrypt($request->password)]);
        }
        $user->update($request->all());
         return ["Message" => "Update Successful"];
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
       $user = User::findOrFail($id);
       $this->validate($request, [
        'name' => 'required|string|max:191',
        'email' => 'required|string|max:191|email|unique:users,email,'.$user->id,
        'password' => 'sometimes|min:6'
    ]);

       $user -> update($request->all());

       return  ["Message" => "Record Updated Successfully"];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        //performing authorization at the controller level
        $this->authorize('isAdmin');


        $user = User::findOrFail($id);

        $user -> delete();

        return ['message' => 'User was deleted'];
    }
}
