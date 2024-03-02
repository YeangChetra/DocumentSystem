<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Structure extends Model
{
    use HasFactory;

    protected $table="positions";

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'secondary_name',
        'levelid',
        'paraent_id',
        'created_by',
        'status'
    ];


    public function doPaginate(){
        $list = DB::table('positions as p')
                    ->leftjoin('levelprefixs as lp','lp.id','=','p.levelid')
                    ->select(
                        'p.id',
                        'lp.description',
                        'lp.secondary_description',
                        'p.name',
                        'p.secondary_name',
                        'p.status',
                        'p.created_at'
                    )
                    ->orderby('created_at','DESC')
                    ->paginate(20);

        return $list;
    }
}
