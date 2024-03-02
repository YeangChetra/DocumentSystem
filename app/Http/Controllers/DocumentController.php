<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\{
    Comment,
    Document,
    Document_file,
    Document_has_command,
    Levelprefix,
    User
};
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use DB;
use Auth;


class DocumentController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Document access|Document create|Document edit|Document delete|Document approve', ['only' => ['index','show', 'documentsType', 'showType']]);
        $this->middleware('role_or_permission:Document create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Document edit', ['only' => ['edit','update','add_documentsByType','editDocument']]);
        $this->middleware('role_or_permission:Document delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:Document approve', ['only' => ['verifications']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getDocumentList(Request $request){
        $current_data = 0;
        return view('comment.index',['current_data'=>$current_data]);
    } 

    public function addComment(Request $request){
        $request->validate([
            'replyMessage' =>'required',
            'incoming_id' =>'required'
        ]);
        
        $outgoing_id = Auth::user()->unique_id;
        return Comment::create([
            'outgoing_msg_id' => $outgoing_id,
            'incoming_msg_id' => $request->incoming_id,
            'msg' => json_encode($request->replyMessage),
        ]);
    }

    public function comment(Request $request, $id){


    }

    public function documentsType(Request $request, $type)
     {
        $type = Crypt::decrypt($type);
        $data = Document::where('documents.type','=',$type)
                    ->orderBy('documents.created_at','ASC')
                    ->paginate(10);
        return view('document.documents',['data'=>$data, 'type'=>$type])
            ->with('i', ($request->input('page', 1) - 1) * 5);
     }

     public function add_documentsByType(Request $request, $type)
     {
        $type = Crypt::decrypt($type);        
        $levelPrefix = Levelprefix::get();
        return view('document.add',['levelPrefix'=>$levelPrefix, 'type'=>$type]);
     }  

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $levelPrefix = levelprefix::get();
        return view('document.add',['levelPrefix'=>$levelPrefix]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'document_no' =>'required|unique:documents',
            'document_date' =>'required',
            'document_of' =>'required',
            'type' =>'required',
            'document_descriptions' =>'required'
        ]);
        $type = Crypt::decrypt($request->type);
        $last_number = Document::select('code')->where('type', $type)->latest()->first();
        if($last_number == null){
            $last_number = 00;
        }
        
        $uuid = (string) Uuid::uuid4();
        
        $document = Document::create([
            'unique_id' => (string) Uuid::uuid4(),
            'code' => $last_number->code + 1,
            'document_no' => $request->document_no,
            'document_date' => $request->document_date,
            'document_of' => $request->document_of,
            'document_descriptions' => $request->document_descriptions,
            'type' => $type,
            'status'=> 1,
            'created_by' => Auth::user()->id,
        ]);

        $doc_id = $document->id;
        // $doc_id = 2;
        if($doc_id != null){
            if($request->hasFile('inputfile'))
            {
                
                $request->validate([                   
                    'inputfile' => 'required'
                ]);
                $files = $request->file('inputfile');

                foreach($files as $key => $file) {
                    if($file->isValid()) {

                        $filename = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $file->move(public_path('/storage/document'), time().'_'.$file->getClientOriginalName());

                        Document_file::create([
                            'document_id' => $doc_id,
                            'displaytitle' => $file->getClientOriginalName(),
                            'filename' => 'document/'.time().'_'.$file->getClientOriginalName(),
                            'file_type' => $extension,
                            'status' => 1,
                            'created_by' => Auth::user()->id,
                        ]);
                    }
                }
            }
            if($request->document_has_commands != null){
                foreach($request->document_has_commands as $k => $document_command){
                    Document_has_command::create([
                        "document_id" => $doc_id,
                        "user_id" => $document_command['user_id'],
                        "permission_type" => $document_command['permission_type'],
                        "status" => 2,
                        'order_by' => $k,
                        'created_by' => Auth::user()->id
                    ]);
                }
            }
        }
        return redirect()->back()->withSuccess('Successfully created !!!');
    }
    public function delete_document($id)
    {
        //
        
        $id = Crypt::decrypt($id);
        $doc_file = Document_file::find($id);

        $doc_file->update();
        return view('document.edit',['data'=>$data, 'comment' => $doc_comment, 'files' => $doc_file,'levelPrefix'=>$levelPrefix]);
    }
    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
    }
    public function showType($id)
    {
        $id = Crypt::decrypt($id);
        $data = Document::Find($id);
        $doc_comment = Document_has_command::where('document_id', $data->id)->where('status', '!=',0)->get();
        $doc_file = Document_file::where('document_id', $data->id)->where('status', '!=',0)->get();
        //
           
        return view('document.showType',['data'=>$data, 'comment' => $doc_comment, 'files' => $doc_file]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }
    public function editDocument($id)    {

        $id = Crypt::decrypt($id);
        $data = Document::Find($id);
        $doc_comment = Document_has_command::where('document_id', $data->id)->where('status', '!=',0)->get();
        $doc_file = Document_file::where('document_id', $data->id)->where('status', '!=',0)->get();
        $levelPrefix = Levelprefix::get();
        //
        return view('document.edit',['data'=>$data, 'comment' => $doc_comment, 'files' => $doc_file,'levelPrefix'=>$levelPrefix]);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        //
    }
}
