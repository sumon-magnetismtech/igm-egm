<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role-create|role-edit|role-view|role-delete', ['only' => ['index','show']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    /*** Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderBy('name')->latest()->paginate();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        $permissions = Permission::orderBy('name')->get();
        return view('roles.create', compact('permissions', 'formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        try{
            DB::transaction(function()use($request){
                $role = Role::create($request->only('name'));
                $role->givePermissionTo($request->only('permission'));
            });
            return redirect()->back()->with('message', "Role has been inserted successfully.");
        }catch(QueryException $e){
            return redirect()->back()->withInput()->with($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $formType = 'edit';
        $permissions = Permission::orderBy('name')->get();
        return view('roles.create', compact('permissions', 'formType', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        try{
            DB::transaction(function()use($request, $role){
                $role->update($request->only('name'));
                $role->syncPermissions($request->only('permission'));
            });
            return redirect()->route('roles.index')->with('message', "Data has been Updated successfully.");
        }catch(QueryException $e){
            return redirect()->back()->withInput()->with($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        try{
            $role->delete();
            return redirect()->route('roles.index')->with('message', "Role has been Deleted successfully.");
        }catch(QueryException $e){
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

}
