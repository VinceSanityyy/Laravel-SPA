<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Hash;
use Gate;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        // $this->authorize('isAdmin');

        if (Gate::allows('isAdmin') || Gate::allows ('isAuthor')) {
           
            return User::latest()->paginate(10);
        }

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
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string|min:8',
       ]);

       return User::create([
        'name' => $request['name'],
        'email' => $request['email'],
        'type' => $request['type'],
        'bio' => $request['bio'],
        'photo' => $request['photo'],
        'password' => Hash::make($request['password'])
       ]);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        //show profile
        return auth('api')->user();
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|unique:users,email,
            '.$user->id,
            'password' => 'sometimes|required|min:8',
           ]);


        $currentPhoto = $user->photo;
        //upload photo imageintervention.com
         if ($request->photo != $currentPhoto){
             $name = time().'.'. explode('/', explode(':', substr($request->photo, 0, strpos
             ($request->photo, ';'))) [1])[1];
             \Image::make($request->photo)->save(public_path('img/profile/').$name);

             $request->merge(['photo' => $name]);

             $userPhoto = public_path('img/profile/').$currentPhoto;
             if(file_exists($userPhoto)){
                @unlink($userPhoto);
             }
         }

         if(!empty($request->passwrd)){
            $request->merge(['password' =>Hash::make($request['password'])]);
         }

         $user->update($request->all());
         return ['message' => 'success'];
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
            'email' => 'required|string|email|unique:users,email,'.$user->id,
            'password' => 'sometimes|string|min:8',
           ]);



         $user->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');


        $user = User::findOrFail($id);
        $user->delete();
        return ['message' => 'User Deleted'];
    }

    public function search(){
        if ($search = \Request::get('q')){
            $users = User::where(function($query) use ($search){
                $query->where('name', 'LIKE', "%$search%")
                      ->orWhere('email', 'LIKE', "%$search%")
                      ->orWhere('type', 'LIKE', "%$search%");
            })->paginate(20);
        }else {
          $users = User::latest()->paginate(5);
        }
        return $users;
    }

    public function getGraph(){
        if (Gate::allows('isAdmin') || Gate::allows ('isAuthor')) {
        //  $users = \DB::table('users')->groupBy('type')->count();

         

         $users = \DB::table('users')
                     ->select(\DB::raw('count(*) as type'))
                     ->groupBy('type')
                     ->get();
         return response()->json($users);
        }
    }
}
