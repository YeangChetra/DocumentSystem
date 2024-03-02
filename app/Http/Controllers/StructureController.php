<?php

namespace App\Http\Controllers;

use App\Models\{
    Structure,
    Levelprefix,
    Level
};
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class StructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:Structure access|Structure create|Structure edit|Structure delete', ['only' => ['index','store']]);
        $this->middleware('role_or_permission:Structure create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Structure edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Structure delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obj= new Structure();
        $structures= $obj->doPaginate();
        $levelprefix = Levelprefix::get();
        return view('structure.structure',['structures'=>$structures, 'levelprefix'=>$levelprefix]);
    }
    
    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $levelprefix = Levelprefix::get();
        return view('structure.new',['levelprefix'=>$levelprefix]);
    }

    
    public function select_Level($id)
	{
        $id = Crypt::decrypt($id);
        $arrLevel = array();
		if(!is_null($id))
		{
			$list = Level::where('levelprefixid','=',$id)->get();
			foreach ($list as $key => $value)
  			{
	  		    $arrLevel[$value->id] = $value->name;
  			}
		}
		return json_encode($arrLevel);
		exit();
	}
    
    public function select_Positions($id)
	{
        
        $id = Crypt::decrypt($id);
        $arrPositions = array();
		if(!is_null($id))
		{          
            $list = Structure::where('levelid','=',$id)->get();
            foreach ($list as $key => $value)
            {
                $arrPositions[$value->id] = $value->name;
            }
		}
		return json_encode($arrPositions);
		exit();
	}
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //check session urlupdaterole
        if (Session::has('urlUpdateStructure')) {
            Session::remove('urlUpdateStructure');
        }
        //
        // dd($request->all());
        $request->validate([
            'name'=>'required',
            'secondary_name'=>'required',
            'department_id' => 'required',
        ]);
        
        $department_id = Crypt::decrypt($request->department_id);
        Structure::create([
                'name'=>$request->name,
                'secondary_name'=>$request->secondary_name,
                'levelid' => $department_id,
                'status' => 1,
                'created_by' => Auth::user()->id,
            ]);
       
        return redirect()->back()->withSuccess('Successfully created !!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Structure $structure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $structures = Structure::find($id);
        $level = Level::find($structures->levelid);
        $levelprefix = Levelprefix::get();
        if (!Session::has('urlUpdateStructure')) {
            Session::put('urlUpdateStructure', route('structures.update',Crypt::encrypt($structures->id)));
        }else{
            Session::remove('urlUpdateStructure');
            Session::put('urlUpdateStructure', route('structures.update',Crypt::encrypt($structures->id)));
        }
        $data='<div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit structures</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id" name="id" value="'.Crypt::encrypt($structures->id).'">
                            <div class="form-group">
                                <label class="form-label">Position in English *</label>
                                <input type="text" id="name" name="name" value="'.$structures->name.'" class="form-control" placeholder="Enter Position in English" data-error=".errorTxt1">
                                <div class="errorTxt1 msg-error"></div>
                            </div>              
                            <div class="form-group">    
                                <label class="form-label">Position in Khmer *</label>
                                <input type="text" id="secondary_name" name="secondary_name" value="'.$structures->secondary_name.'" class="form-control" placeholder="Enter Position in English" data-error=".errorTxt1">
                                <div class="errorTxt1 msg-error"></div>
                            </div>
                            <div class="form-group">
                            <label class="form-label">Level *</label>
                                <select class="form-control" id="levelprefixId"  value="'.$structures->levelprefixId.'" class="form-control" data-error=".errorTxt1"><option value="">Select Option</option>';
                                foreach($levelprefix as $item){
                                $data .='<option value="'.Crypt::encrypt($item->id).'"';
                                        if($item->id == $level->levelprefixid){
                                            $data .='selected="selected"';
                                        }
                                    $data .='>'.$item->description.'</option>';
                                }
                                $data .='</select>                
                                <div class="errorTxt1 msg-error"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Department *</label>
                                <select class="form-control" id="department"  value="'.$structures->levelid.'" class="form-control" data-error=".errorTxt1" name="department">
                                </select>
                                <input type="hidden" id="hidden_department" value="'.$structures->levelid.'">
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
            $("select#levelprefixId").change(function(){
                var me = $(this),
                        id = me.val();
                    var department_obj = $("#department");
                    var department_id = $("#hidden_department").val();
                    getdepartmentByLevel(id, department_id, department_obj);
            }).trigger("change");
            
            $(document).on("click", ".btn-update", function() {
                $(".loading-content-save").fadeIn();
                setTimeout(function(){
                    $(".loading-content-save").fadeOut();
                },500);
                $("form#formPositionsUpdate").submit();
            });

            $(function(){
                $("form#formPositionsUpdate").attr("action","'.route('structures.update',Crypt::encrypt($structures->id)).'");
            });';

        echo json_encode($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $id = Crypt::decrypt($id);
        $structures = Structure::find($id);
        $levelprefix = Levelprefix::get();
        // dd($request->all());
        $request->validate([
            'name'=>'required|unique:positions,name,'.$structures->id.',id',
            'secondary_name'=>'required|unique:positions,secondary_name,'.$structures->id.',id',
            'department' => 'required',
        ]);

        $structures->update([
                'name'=>$request->name,
                'secondary_name'=>$request->secondary_name,
                'levelid' => $request->department,
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            

        //check session urlUpdateStructure
        if (Session::has('urlUpdateStructure')) {
            Session::remove('urlUpdateStructure');
        }

        return redirect()->back()->withSuccess('Successfully updated !!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
       $ids = $request->ids;
       $actions = $request->actions;
       if($ids !=null){
        foreach($ids as $id)
            {   //find data
                $data = Structure::find($id);
                if($actions == 'delete'){
                    $account = Structure::find($id)->delete();

                }else if($actions == 'active'){
                    $account = Structure::find($id)->update(['status' => 1]);
                }else{
                    $account = Structure::find($id)->update(['status' => 0]);
                }
            }
        }else{
            return redirect()->back()->withError('Missing select item that you want to delete !!!');
        }
        return redirect()->back()->withSuccess('Successfully '.$actions.'!!!');
    }
}
