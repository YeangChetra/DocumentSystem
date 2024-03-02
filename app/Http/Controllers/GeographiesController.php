<?php

namespace App\Http\Controllers;

use App\Models\Geogrphy;
use Illuminate\Http\Request;

class GeographiesController extends Controller
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
        $data = User::whereNotIn('id',[1])
            ->orderBy('name','ASC')
            ->paginate(10);
        return view('users.accounts',compact('data'))
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
    public function show(Geogrphy $geogrphy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Geogrphy $geogrphy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Geogrphy $geogrphy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Geogrphy $geogrphy)
    {
        //
    }
}
