<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\UserLocation;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use DB;
use Illuminate\Support\Arr;


class UserLocationController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:UserLocation access|UserLocation create|UserLocation edit|UserLocation delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:UserLocation create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:UserLocation edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:UserLocation delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = UserLocation::orderBy('name','ASC')
            ->paginate(10);
        return view('user_locations.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserLocation $userLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserLocation $userLocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserLocationRequest $request, UserLocation $userLocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserLocation $userLocation)
    {
        //
    }
}
