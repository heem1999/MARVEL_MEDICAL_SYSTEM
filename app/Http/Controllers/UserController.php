<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use App\Branches;
use App\Models\Image;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Administrator', ['only' => ['index']]);
        $this->middleware('permission:Administrator', ['only' => ['create','store']]);
        $this->middleware('permission:Administrator', ['only' => ['edit','update']]);
        $this->middleware('permission:Administrator', ['only' => ['destroy']]);
    }
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $data = User::orderBy('id', 'DESC')->paginate(5);
        return view('users.show_users', compact('data'))->with('i', ($request->input('page', 1) - 1) * 5);
    }


    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $branches = Branches::all();
        $roles = Role::pluck('name', 'name')->all();

        return view('users.Add_user', compact('roles', 'branches'));
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
'name' => 'required',
//'email' => 'required|email|unique:users,email',
'password' => 'required|same:confirm-password',
'roles_name' => 'required'
]);
        $path ='';
        if (isset($request->signature)) {
            $validatedData = $request->validate([
        'signature' => 'image|mimes:jpg,png,jpeg',
       ]);
    
          
            $img_ext = $request->file('signature')->getClientOriginalExtension();
            $filename = 'signature-logo-' . time() . '.' . $img_ext;
            $path = $request->file('signature')->move(public_path().'/signatures', $filename);//image save public folder
            $path ="/signatures"."/".$filename;
        }
       
        $input = $request->all();
        $input['name'] =  $input['email'];

        $input['password'] = Hash::make($input['password']);
        if ($path) {
            $input['signature'] = $path;
        }
        $user = User::create($input);
        $user->assignRole($request->input('roles_name'));
        return redirect()->route('users.index')
->with('success', 'User add successfully!!');
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $branches = Branches::all();
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('users.edit', compact('user', 'roles', 'userRole', 'branches'));
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
        $this->validate($request, [
                'name' => 'required',
                //'email' => 'required|email|unique:users,email,'.$id,
                'password' => 'same:confirm-password',
                'roles' => 'required'
                ]);
        $path ='';
        if (isset($request->signature)) {
            $validatedData = $request->validate([
        'signature' => 'image|mimes:jpg,png,jpeg',
       ]);
            $img_ext = $request->file('signature')->getClientOriginalExtension();
            $filename = 'signature-logo-' . time() . '.' . $img_ext;
            $path = $request->file('signature')->move(public_path().'/signatures', $filename);//image save public folder
           
            $path ="/signatures"."/".$filename;
        }
        
        $input = $request->all();
        
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        if ($path) {
            $input['signature'] = $path;
        }
        
        $input['name'] =  $input['name'];
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')
->with('success', 'User edited successfully!!');
    }
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request)
    {
        User::find($request->user_id)->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!!');
    }


    

    
}