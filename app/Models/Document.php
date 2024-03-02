<?php

namespace App\Models;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_id',
        'code',
        'document_no',
        'document_date',
        'document_of',
        'document_descriptions',
        'type',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    public function getDocumentList($type){
        
        $user = Auth::user();
        $user->hasRole('Super Admin', 'Administrator', 'Supper User', 'User');
        $doc_comment ="";
        if($user->hasRole('Super Admin') || $user->hasPermissionTo('Document Full access')){
            $doc_comment = DB::table('documents  as d')
                        ->select('d.id','d.document_no','d.document_date','d.document_of','d.document_descriptions','d.type', 'd.created_at')
                        ->where('d.type','=',1)
                        ->where('d.status', '!=',0)
                        ->get();
        }else{
            $has_com = DB::table('document_has_commands');
            $doc_comment = DB::table('documents as d')
                            ->select('d.id','d.document_no','d.document_date','d.document_of','d.document_descriptions','d.type', 'd.created_at', 'com.user_id')
                            ->leftJoinSub($has_com, 'com',  function($join){ 
                                $join->on('d.id','=','com.document_id')
                                    ->groupby('com.docment_id'); 
                            })
                            ->where('user_id','=',Auth::user()->id)
                            ->where('d.status', '!=',0)->get();
        }

        return $doc_comment;
    }
}
