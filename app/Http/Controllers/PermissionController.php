<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Gate;



class PermissionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:Permission access|Permission create|Permission edit|Permission delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Permission create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Permission edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Permission delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission= Permission::orderBy('created_at','desc')
        ->paginate(10);;

        return view('permission.permission',['permissions'=>$permission]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permission.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validation  permissions_list
              //check session urlUpdatePermission
            if (Session::has('urlUpdatePermission')) {
                Session::remove('urlUpdatePermission');
            }
            //
            $request->validate([
                'name'=>'required|unique:permissions',
                'permissions_list'=>'required'
            ]);

            foreach($request->permissions_list as $k => $v){
                
                if($v == "access" || $v == "create" || $v == "edit" || $v == "delete" || $v == "approve"){
                    $name = $request->name." ".$v;
                    $permission = Permission::create(['name'=>$name]);
                }
            }
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
        $id = Crypt::decrypt($id);
        $permissions = Permission::find($id);
        // dd($permissions);
        //create session urlUpdatePermission
        if (!Session::has('urlUpdatePermission')) {
            Session::put('urlUpdatePermission', route('permissions.update',Crypt::encrypt($permissions->id)));
        }else{
            Session::remove('urlUpdatePermission');
            Session::put('urlUpdatePermission', route('permissions.update',Crypt::encrypt($permissions->id)));
        }
        $data='<div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Permissions</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id" name="id" value="'.Crypt::encrypt($permissions->id).'">
                            <div class="form-group">
                                <label class="form-label">Permission *</label>
                                <input type="text" id="name" name="name" value="'.$permissions->name.'" class="form-control"
                                placeholder="Enter Permissions" data-error=".errorTxt1">
                                <div class="errorTxt1 msg-error"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary btn-update">Update Change</button>
                        </div>
                        <div class="overlay loading-content-save" style="display:none;">
                                <i class="fa fa-spinner fa-spin"></i>
                        </div>
                    </div>
                </div>';
        //render script
        $data.='<script type="text/javascript">
            $(document).on("click", ".btn-update", function() {
                $(".loading-content-save").fadeIn();
                setTimeout(function(){
                    $(".loading-content-save").fadeOut();
                },500);
                $("form#formPermissionUpdate").submit();
            });

            $(function(){
                $("form#formPermissionUpdate").attr("action","'.route('permissions.update',Crypt::encrypt($permissions->id)).'");
            });';
        echo json_encode($data);
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
        $permissions = Permission::find($id);
        $request->validate(['name'=>'required|unique:permissions,name,'.$permissions->id.',id',]);

        $permissions->update(['name'=>$request->name]);

        //check session urlupdatepermissions
        if (Session::has('urlUpdatepermissions')) {
            Session::remove('urlUpdatepermissions');
        }
        return redirect()->back()->withSuccess('Successfully updated !!!');
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
                 $data = Permission::find($id);
                 if($actions == 'delete')
                     $permission = Permission::find($id)->delete();
                 
             }
         }else{
             return redirect()->back()->withError('Missing select item that you want to delete !!!');
         }
         return redirect()->back()->withSuccess('Successfully '.$actions.'!!!');
    }
}
