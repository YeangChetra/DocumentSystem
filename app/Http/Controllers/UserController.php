<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Structure,
    Levelprefix,
    User
};

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
    
class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:User access|User create|User edit|User delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:User create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:User edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:User delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $positions = DB::table('positions')
                ->select('id as positions_id','name as positions_en', 'secondary_name as positions_km')
                ->where('status', 1);
        $data = User::whereNotIn('users.id',[1])
                    ->leftJoinSub($positions, 'p', function($join){
                        $join->on('p.positions_id','=','users.position_id');
                    })
                    ->orderBy('users.name','ASC')
                    ->paginate(10);

        return view('users.accounts',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function select_user($id)
	{
        $arrUsers = array();
		if($id != "nullable")
		{
			$list = User::where('position_id','=',$id)->get();
			foreach ($list as $key => $value)
  			{
	  		    $arrUsers[$value->id] = $value->name;
  			}
		}
		return json_encode($arrUsers);
		exit();
	}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::whereNotIn('name',['Super Admin'])
        ->orderBy('name','ASC')
        ->get();
        $levelprefix = Levelprefix::get();
        return view('users.add',['roles'=>$roles,'levelprefix'=>$levelprefix]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // dd($request->all());
        $request->validate([
            'name'=>'required',
            'secondary_name'=>'required',
            'phone'=>'required|unique:users',
            'email' => 'required|email|unique:users',
            'password'=>['required','confirmed',Password::min(8)->letters()->numbers()->mixedCase()->symbols()],
            'position_id' => 'required',
            'levelid' => 'required',
            'levelprefixid' => 'required',
        ]);
        $request_levelprefixid = Crypt::decrypt($request->levelprefixid);
        $uuid = (string) Str::uuid();
        // dd($uuid);
        $admin = User::create([
            'unique_id'=>$uuid,
            'name'=>$request->name,
            'secondary_name'=>$request->secondary_name,
            'phone'=>$request->phone,
            'email'=>$request->email,
            'position_id'=> $request->position_id,
            'levelid'=>$request->levelid,
            'levelprefixid'=>$request_levelprefixid,
            'password'=> Hash::make($request->password),
            'status'=> 1,
        ]);

        $roles = Role::whereIn('id',$request->roles)->pluck('id','id');
        $admin->syncRoles($roles);
        return redirect()->back()->withSuccess('Successfully created !!!');
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
        return view('users.show',compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $admin = User::find($id);
        $role = Role::whereNotIn('name',['Super Admin'])->get();
        $level = 
        $admin->roles;
        $levelprefix = Levelprefix::get();
       return view('users.edit',['admin'=>$admin,'roles' => $role,'levelprefix' => $levelprefix]);
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
        $id = Crypt::decrypt($id);
        $admin = User::find($id);
        
        $validated = $request->validate([
            'name'=>'required',
            'phone'=>'required|unique:users,phone,'.$admin->id.',id',
            'email' => 'required|email|unique:users,email,'.$admin->id.',id',
            'position_id' => 'required',
            'levelid' => 'required',
            'levelprefixid' => 'required',
        ]);

        $validated['levelprefixid'] = Crypt::decrypt($request->levelprefixid);

        if($request->password != null){
            $request->validate([
                'password'=>['required',Password::min(8)->letters()->numbers()->mixedCase()->symbols()]
            ]);
            $validated['password'] = Hash::make($request->password);
        }
        // dd($validated);
        $admin->update($validated);
        $roles = Role::whereIn('id',$request->roles)->pluck('id','id');
        $admin->syncRoles($roles);
        
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       $ids = $request->ids;
       $actions = $request->actions;
       if($ids !=null){
        foreach($ids as $id)
            {   //find data
                $data = User::find($id);
                if($actions == 'delete'){
                    //delete image
                    //$image_path = public_path("app-assets/images/User/".$data->profile);
                    //    if(File::exists($image_path)){
                    //        File::delete($image_path);
                    //    } 
                    //delete data
                    $account = User::find($id)->delete();

                }else if($actions == 'active'){
                    //if($data->role == "Manager"){
                    //    $account = DB::table('tblUser')
                    //            ->where('tblUser.areaid','=',$data->areaid)
                    //            ->get();
                    //    foreach($account as $item)
                    //    {
                    //        DB::table('tblUser')->where('adid',$item->adid)->update(['status' => 1]);
                    //    }
                    //}else{
                    //    if($data->status != 1)
                    //        DB::table('tblUser')->where('adid',$list)->update(['status' => 1]);
                    //}
                    $account = User::find($id)->update(['status' => 1]);
                }else{
                    //$filter = DB::table('tblUser')->where('adid',$list)->first();
                    //check manager account to add inactive all member
                    //if($data->role == "Manager"){
                    //    $account = DB::table('tblUser')
                    //            ->where('tblUser.areaid','=',$data->areaid)
                    //            ->get();
                    //    foreach($account as $item)
                    //    {
                    //        DB::table('tblUser')->where('adid',$item->adid)->update(['status' => 0]);
                    //    }
                    //}else{
                    //    if($data->status !=0)
                    //        DB::table('tblUser')->where('adid',$list)->update(['status' => 0]);
                    //}
                    $account = User::find($id)->update(['status' => 0]);
                }
            }
        }else{
            return redirect()->back()->withError('Missing select item that you want to delete !!!');
        }
        return redirect()->back()->withSuccess('Successfully '.$actions.'!!!');
    }
}