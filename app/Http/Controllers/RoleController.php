<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Gate;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:Role access|Role create|Role edit|Role delete', ['only' => ['index','store']]);
        $this->middleware('role_or_permission:Role create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Role edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Role delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role= Role::whereNotIn('name',['Super Admin'])
            ->orderBy('name','ASC')
            ->paginate(10);
        $permissions = Permission::orderBy('name','ASC')->get();

        return view('role.role',['roles'=>$role,'permissions'=>$permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('role.new',['permissions'=>$permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        //check session urlupdaterole
        if (Session::has('urlUpdateRole')) {
            Session::remove('urlUpdateRole');
        }
        //
        $request->validate(['name'=>'required|unique:roles']);
      
        $permissions = Permission::whereIn('id', $request->permissions)->pluck('id','id');

        // dd($permissions);
        $role = Role::create(['name'=>$request->name]);

        $role->syncPermissions($permissions);
        
        return redirect()->back()->withSuccess('Successfully created !!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($search)
    {
        $adminUser = \Auth::guard('admin')->user();
        $terms = explode(" ", $search);
        $roles = Role::orWhere(function ($query) use ($terms) {
                    foreach ($terms as $term) {
                        // Loop over the terms and do a search for each.
                        //$query->where('title', 'like', '%' . $term . '%');
                        $query->where([['name','!=','Super Admin'],['name', 'LIKE', '%' . $term . '%'],]);
                    }
                })
                ->orderBy('name','ASC')
                ->paginate(10);
       //reder data on table
        $data = '<div class="card card-static-2 mb-30">
                 <div class="card-title-2">
                  <h4>All Roles</h4>
                    </div>
                    <div class="card-body-table">
                    <div class="table-responsive">
                    <table class="table ucp-table table-hover">
                    <thead>
                    <tr>
                    <th style="width:60px"><input type="checkbox" class="form-control check-all"></th>
                    <th>Role_Name</th>
                    <th>Permisstions</th>
                    <th>Created</th>
                    <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>';
        foreach($roles as $role)
        {
            $data.='<tr>
                    <td><input type="checkbox" class="form-control check-item" name="ids[]" value='.$role->id.'></td>
                    <td>'.$role->name.'</td>
                    <td>';
                    foreach($role->permissions as $permission){
                        $data.='<span class="badge-item badge-status" style="margin-bottom: 5px;">'.$permission->name.'</span> ';
                    }
                    $data.= '</td>';
                    $data.='<td>'.\Carbon\Carbon::parse($role->create_date)->format('d-M-y h:i A').'</td>';
                    $data.='<td class="action-btns">';
                        if($adminUser->can('Role edit')){
                            $data.='<a href="'.route('roles.edit',Crypt::encrypt($role->id)).'" class="edit-btn" title="Edit" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit edit" id="'.Crypt::encrypt($role->id).'"></i> Edit</a>';
                        }
                    $data.='</td>
                    </tr>';
        }
        $data.= '</tbody></table></div>';

        $data.='<div class="text-center" style="float: left;padding-top: 15px;padding-left: 5px;">
                    <p style="font-size: 14px;">Showing '.$roles->firstItem().' to '.$roles->lastItem().' of    '.$roles->total().' entries</p>
                </div>';
        //reder pagination
        $data.= '<div class="text-center" style="float: right;padding-top: 5px;padding-right: 5px;">
                    <nav>';
        if($roles->lastPage() > 1){
                    $data.= '<ul class="pagination">';
                    if($roles->currentPage() == 1){
                        $data.='<li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                            <span class="page-link" aria-hidden="true">Previous</span>';
                    }else{
                         $data.='<li class="page-item" aria-disabled="true" aria-label="« Previous">
                            <a class="page-link page-click cus-color-blue" id="1">Previous</a>';
                    }
                    $data.= '</li>';
                    for($i = 1; $i <= $roles->lastPage(); $i++){
                        $half_total_links = floor(7 / 2);
                        $from = $roles->currentPage() - $half_total_links;
                        $to = $roles->currentPage() + $half_total_links;
                        if ($roles->currentPage() < $half_total_links) {
                            $to += $half_total_links - $roles->currentPage();
                        }
                        if ($roles->lastPage() - $roles->currentPage() < $half_total_links) {
                            $from -= $half_total_links - ($roles->lastPage() - $roles->currentPage()) - 1;
                        }
                        if($from < $i && $i < $to){
                        if($roles->currentPage() == $i){
                            $data.= '<li class="page-item active" aria-current="page"><span class="page-link">'. $i .'</span>';
                        }else{
                            $data.= '<li class="page-item" aria-current="page"><a class="page-link page-click cus-color-blue" id='.$i.'>'. $i .'</a>';
                        }
                        $data.='</li>';
                        }
                    }
                    if($roles->currentPage() == $roles->lastPage()){
                        $data.= '<li class="page-item disabled">
                                    <a class="page-link" id='. $roles->lastPage() .' rel="next"  aria-label="Next »">Next</a>
                                </li>
                            </ul>';
                    }else{
                        $data.= '<li class="page-item">
                                    <a class="page-link page-click cus-color-blue" id='. $roles->lastPage() .' rel="next"  aria-label="Next »">Next</a>
                                </li>
                            </ul>';
                    }
        }
        $data.= '</nav></div></div></div>';
        echo json_encode($data);
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
        $permissions = Permission::get();
        $role = Role::find($id);
        $role->permissions;

        //create session urlupdaterole
        if (!Session::has('urlUpdateRole')) {
            Session::put('urlUpdateRole', route('roles.update',Crypt::encrypt($role->id)));
        }else{
            Session::remove('urlUpdateRole');
            Session::put('urlUpdateRole', route('roles.update',Crypt::encrypt($role->id)));
        }

        //render
        $data='<div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                <input type="hidden" id="id" name="id" value="'.Crypt::encrypt($role->id).'">
                <div class="form-group">
                <label class="form-label">Role Name*</label>
                <input type="text" id="name" name="name" value="'.$role->name.'" class="form-control"
                placeholder="Enter Role Name" data-error=".errorTxt1">
                <div class="errorTxt1 msg-error"></div>
                </div> 
                <div class="form-group mb-3">
                <label class="form-label tl-color">Roles</label>
                </div>
                <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                <div class="form-group mb-3">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" id="checkalls" type="checkbox"';
                    if($permissions->count() == $role->permissions->count()){
                        $data.='checked';
                    }
                    $data.='/>
                        <label class="custom-control-label" for="checkalls">Full Control</label>
                    </div>
                </div>
            </div>';
        foreach($permissions as $permission){
        $data.='<div class="col-lg-4 col-md-4 col-sm-4 col-4">
                <div class="form-group mb-3">
                    <div class="custom-control custom-checkbox">
                        <input class="cb-elements custom-control-input" id="'.$permission->id.'" name="permissions[]" type="checkbox" value="'.$permission->id.'"';
                        if(old('permissions')){
                            foreach(old('permissions') as $item){
                                if($item == $permission->id){
                                    $data.='checked'; 
                                }
                            }
                        }
                        if(count($role->permissions->where('id',$permission->id))){
                            $data.='checked'; 
                        }
                    $data.='/>
                        <label class="custom-control-label" for="'.$permission->id.'">'.$permission->name.'
                        </label>
                    </div>
                </div>
            </div>';
            }
        $data.='</div>
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
    $(document).on("change", "#checkalls", function() {
        $(".cb-elements").prop("checked",this.checked);
    });

    $(document).on("change", ".cb-elements", function() {
        if ($(".cb-elements:checked").length == $(".cb-elements").length){
            $("#checkalls").prop("checked",true);
        }
        else {
            $("#checkalls").prop("checked",false);
        }
    });

    $(document).on("click", ".btn-update", function() {
        $(".loading-content-save").fadeIn();
        setTimeout(function(){
            $(".loading-content-save").fadeOut();
        },500);
        $("form#formRoleUpdate").submit();
    });

    $(function(){
        $("form#formRoleUpdate").attr("action","'.route('roles.update',Crypt::encrypt($role->id)).'");
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
        $role = Role::find($id);
        $request->validate(['name'=>'required|unique:roles,name,'.$role->id.',id',]);

        $role->update(['name'=>$request->name]);
        
        $permissions = Permission::whereIn('id', $request->permissions)->pluck('id','id');

        $role->syncPermissions($permissions);

        //check session urlupdaterole
        if (Session::has('urlUpdateRole')) {
            Session::remove('urlUpdateRole');
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
                $data = Role::find($id);
                if($actions == 'delete')
                    $role = Role::find($id)->delete();
                
            }
        }else{
            return redirect()->back()->withError('Missing select item that you want to delete !!!');
        }
        return redirect()->back()->withSuccess('Successfully '.$actions.'!!!');
    }
}
