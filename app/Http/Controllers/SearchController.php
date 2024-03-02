<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Auth;
use DB;
use Helper;
class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:User access|User create|User edit|User delete', ['only' => ['search_admin']]);
        $this->middleware('role_or_permission:Permission access|Permission create|Permission edit|Permission delete', ['only' => ['search_permissions']]);
    }

    //search admin account
   public function search_admin(Request $request)
   {
       $adminUser = \Auth::user();
       $status = $request->status;
       $search = $request->search;
       if($search!=null){
            $terms = explode(" ", $search);
            $admin = User::orWhere(function ($query) use ($terms, $status, $adminUser) {
                        foreach ($terms as $term) {
                            // Loop over the terms and do a search for each.
                            //$query->where('title', 'like', '%' . $term . '%');
                            $query->where([['status',$status] , ['name','!=',$adminUser->name], ['name', 'LIKE', '%' . $term . '%'],]);
                        }
                    })
                    ->orderBy('name','ASC')
                    ->paginate(10);
       }else{
            $admin = User::where([['status',$status], ['name','!=',$adminUser->name]])
               ->orderBy('name','ASC')
               ->paginate(10);
       }
       
       //reder data on table
        $data = '<div class="card card-static-2 mt-30 mb-30">
                    <div class="card-title-2" style="padding-top: 5px;padding-bottom: 5px;">
                        <h4>All UserAccounts</h4>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="input-group">
                        <label style="margin-top:auto;margin-bottom: auto;padding-right: 5px;font-size: 14px;">Show</label> 
                        <select id="showing" name="showing" class="form-control">
                        <option selected value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                        <option value="all">all</option>
                        </select>
                        <label style="margin-top:auto;margin-bottom: auto;padding-left: 5px;font-size: 14px;">entries</label>
                        </div>
                    </div>
                    </div>
                    <div class="card-body-table">
                    <div class="table-responsive">
                    <table class="table ucp-table table-hover">
                    <thead>
                    <tr>
                    <th style="width:60px"><input type="checkbox" class="form-control check-all"></th>
                    <th style="width:100px">Profile</th>
                    <th>Full_Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Created</th>
                    <th>Status</th>
                    <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>';
        foreach($admin as $list)
        {
            $data.='<tr>
                    <td><input type="checkbox" class="form-control check-item" name="ids[]" value='.$list->id.'></td>
                    <td>'
                        . (($list->profile_photo_url)? '<img style="width: 35px;border-radius: 50%;border: 1px #45bbe0 solid;" src="'.($list ? $list->profile_photo_url : '').'" alt="'.($list ? $list->name : '' ).'">' : '<i style="padding-left:2px;padding-right: 2px;color: #f55d2c;">'. ($list ? $list->name : '').'</i>').
                    '</td>
                    <td>'.$list->name.'</td>
                    <td>'.$list->email.'</td>
                    <td>'.$list->phone.'</td>
                    <td>';
                    foreach($list->roles as $role){
                        $data.='<span class="badge-item badge-status" style="background-color: darkblue;">'.$role->name.'</span> ';
                    }
                    $data.= '</td>';
                    $data.='<td>'.\Carbon\Carbon::parse($list->create_date)->format('d-M-y h:i A').'</td>';
                    if($list->status){
                        $data.='<td><span class="badge-item badge-status">Active</span></td>';
                    }else{
                        $data.='<td><span class="badge-item badge-status">Inactive</span></td>';
                    }
                    $data.='<td class="action-btns">';
                        if($adminUser->can('User edit')){
                            $data.='<a href="'.route('users.edit',Crypt::encrypt($list->id)).'" class="edit-btn"><i class="fas fa-edit edit"></i> Edit</a>';
                        }
                    $data.='</td>
                    </tr>';
        }
        $data.= '</tbody></table></div>';

        $data.='<div class="text-center" style="float: left;padding-top: 15px;padding-left: 5px;">
                    <p style="font-size: 14px;">Showing '.$admin->firstItem().' to '.$admin->lastItem().' of    '.$admin->total().' entries</p>
                </div>';
        //reder pagination
        $data.= '<div class="text-center" style="float: right;padding-top: 5px;padding-right: 5px;">
                    <nav>';
        if($admin->lastPage() > 1){
                    $data.= '<ul class="pagination">';
                    if($admin->currentPage() == 1){
                        $data.='<li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                            <span class="page-link" aria-hidden="true">Previous</span>';
                    }else{
                         $data.='<li class="page-item" aria-disabled="true" aria-label="« Previous">
                            <a class="page-link page-click cus-color-blue" id="1">Previous</a>';
                    }
                    $data.= '</li>';
                    for($i = 1; $i <= $admin->lastPage(); $i++){
                        $half_total_links = floor(7 / 2);
                        $from = $admin->currentPage() - $half_total_links;
                        $to = $admin->currentPage() + $half_total_links;
                        if ($admin->currentPage() < $half_total_links) {
                            $to += $half_total_links - $admin->currentPage();
                        }
                        if ($admin->lastPage() - $admin->currentPage() < $half_total_links) {
                            $from -= $half_total_links - ($admin->lastPage() - $admin->currentPage()) - 1;
                        }
                        if($from < $i && $i < $to){
                        if($admin->currentPage() == $i){
                            $data.= '<li class="page-item active" aria-current="page"><span class="page-link">'. $i .'</span>';
                        }else{
                            $data.= '<li class="page-item" aria-current="page"><a class="page-link page-click cus-color-blue" id='.$i.'>'. $i .'</a>';
                        }
                        $data.='</li>';
                        }
                    }
                    if($admin->currentPage() == $admin->lastPage()){
                        $data.= '<li class="page-item disabled">
                                    <a class="page-link" id='. $admin->lastPage() .' rel="next"  aria-label="Next »">Next</a>
                                </li>
                            </ul>';
                    }else{
                        $data.= '<li class="page-item">
                                    <a class="page-link page-click cus-color-blue" id='. $admin->lastPage() .' rel="next"  aria-label="Next »">Next</a>
                                </li>
                            </ul>';
                    }
        }
        $data.= '</nav></div></div></div>';
        echo json_encode($data);
   }
    //search admin account
    public function search_permissions(Request $request)
    {
        $adminUser = \Auth::user();
        $search = $request->search;
        if($search != null){
            $terms = explode(" ", $search);
            $permission = Permission::orWhere(function ($query) use ($terms) {
                        foreach ($terms as $term) {
                            // Loop over the terms and do a search for each.
                            $query->where([['name', 'LIKE', '%' . $term . '%'],]);
                        }
                    })
                    ->orderBy('created_at','desc')
                    ->paginate(10);
        }else{
            $permission = Permission::orderBy('created_at','desc')
                ->paginate(10);
        }
        
        //reder data on table
        $data = '<div class="card card-static-2 mb-30">
                    <div class="card-title-2">
                        <h4>All Permissions</h4>
                    </div>
                    <div class="card-body-table">
                        <div class="table-responsive">
                            <table class="table ucp-table table-hover">
                            <thead>
                                <tr>
                                <th style="width:60px"><input type="checkbox" class="form-control check-all"></th>
                                <th>Permisstions</th>
                                <th>Guard Name</th>
                                <th>Created</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>';
                                foreach($permission as $list)
                                {
                                    $data.='<tr>
                                            <td><input type="checkbox" class="form-control check-item" name="ids[]" value='.$list->id.'></td>
                                            <td>'.$list->name.'</td>
                                            <td>'.$list->guard_name.'</td>
                                            <td>'.\Carbon\Carbon::parse($list->create_date)->format('d-M-y h:i A').'</td>
                                            <td class="action-btns">';
                                                if($adminUser->can('User edit')){
                                                    $data.='<a href="'.route('permissions.edit',Crypt::encrypt($list->id)).'" class="edit-btn" title="Edit"data-toggle="modal" data-target="#editModal"><i class="fas fa-edit edit" id="'.Crypt::encrypt($list->id).'">Edit</i></a>';
                                                }
                                    $data.='</td>
                                        </tr>';
                                }
                    $data.= '</tbody>
                    </table>
                </div>';

        $data.='<div class="text-center" style="float: left;padding-top: 15px;padding-left: 5px;">
                    <p style="font-size: 14px;">Showing '.$permission->firstItem().' to '.$permission->lastItem().' of    '.$permission->total().' entries</p>
                </div>';
        //reder pagination
        $data.= '<div class="text-center" style="float: right;padding-top: 5px;padding-right: 5px;">
                    <nav>';
        if($permission->lastPage() > 1){
                    $data.= '<ul class="pagination">';
                    if($permission->currentPage() == 1){
                        $data.='<li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                            <span class="page-link" aria-hidden="true">Previous</span>';
                    }else{
                            $data.='<li class="page-item" aria-disabled="true" aria-label="« Previous">
                            <a class="page-link page-click cus-color-blue" id="1">Previous</a>';
                    }
                    $data.= '</li>';
                    for($i = 1; $i <= $permission->lastPage(); $i++){
                        $half_total_links = floor(7 / 2);
                        $from = $permission->currentPage() - $half_total_links;
                        $to = $permission->currentPage() + $half_total_links;
                        if ($permission->currentPage() < $half_total_links) {
                            $to += $half_total_links - $permission->currentPage();
                        }
                        if ($permission->lastPage() - $permission->currentPage() < $half_total_links) {
                            $from -= $half_total_links - ($permission->lastPage() - $permission->currentPage()) - 1;
                        }
                        if($from < $i && $i < $to){
                        if($permission->currentPage() == $i){
                            $data.= '<li class="page-item active" aria-current="page"><span class="page-link">'. $i .'</span>';
                        }else{
                            $data.= '<li class="page-item" aria-current="page"><a class="page-link page-click cus-color-blue" id='.$i.'>'. $i .'</a>';
                        }
                        $data.='</li>';
                        }
                    }
                    if($permission->currentPage() == $permission->lastPage()){
                        $data.= '<li class="page-item disabled">
                                    <a class="page-link" id='. $permission->lastPage() .' rel="next"  aria-label="Next »">Next</a>
                                </li>
                            </ul>';
                    }else{
                        $data.= '<li class="page-item">
                                    <a class="page-link page-click cus-color-blue" id='. $permission->lastPage() .' rel="next"  aria-label="Next »">Next</a>
                                </li>
                            </ul>';
                    }
        }
        $data.= '</nav></div></div></div>';
        echo json_encode($data);
    }    //search admin account
    public function getComment(Request $request, $id)
    {
        $outgoing_id = Auth::user()->unique_id; // id current user
        $incoming_id = $id; // id show send to
        
        $obj_d = new Document();
        $doc = $obj_d::Find($id);

        $query = DB::table('comments as c')
                    ->leftjoin('users as u', 'u.unique_id','=','c.outgoing_msg_id')
                    ->where('c.incoming_msg_id','=',$incoming_id)
                    ->orderby('c.id')
                    ->get();
        $data= '';
        $i =1;
        foreach ($query as $value) {
            if($value->outgoing_msg_id == $outgoing_id){
                $data .= "<div class='msg messageSent'>
                            ".html_entity_decode(str_replace('\r\n', "<br \>",str_replace('"','',$value->msg)))."
                            <span class='timestamp'>".Helper::getTimesStatus($value->created_at, $doc->updated_at)."</span>
                        </div>";
            }else{
                $data .= "<div class='msg messageReceived'>
                            ".html_entity_decode(str_replace('\r\n', "<br \>",str_replace('"','',$value->msg)))."
                            <span class='timestamp'>".Helper::getTimesStatus($value->created_at, $doc->updated_at)."</span>
                        </div>";  

            }                
        }

        return $data;
        
    }
}
