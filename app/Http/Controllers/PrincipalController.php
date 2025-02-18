<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrincipalRequest;
use App\Principal;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PrincipalController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:principal-create|principal-edit|principal-view|principal-delete', ['only' => ['index','show']]);
        $this->middleware('permission:principal-create', ['only' => ['create','store']]);
        $this->middleware('permission:principal-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:principal-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $principals = Principal::latest()->get();
        return view('principals.index', compact('principals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        return view('principals.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrincipalRequest $request)
    {
        $principalData = $request->only('name', 'code', 'description');
        try{
            Principal::create($principalData);
            return redirect()->route('principals.index')->with('message','Principal Created Successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Principal $principal)
    {
        $formType = 'edit';
        return view('principals.create', compact('principal', 'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PrincipalRequest $request, Principal $principal)
    {
        try{
            $principalData = $request->only('name', 'code', 'description');
            $principal->update($principalData);
            return redirect()->route('principals.index')->with('message','Principal Updated Successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Principal $principal)
    {
        try{
            $principal->delete();
            return redirect(route('principals.index'))->with('message', 'The Principal Deleted Successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
