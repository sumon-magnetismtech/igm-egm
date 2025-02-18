<?php

namespace App\Http\Controllers\MLO;

use App\Http\Controllers\Controller;
use App\MLO\Delayreason;
use App\MLO\Mloblinformation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class DelayreasonController extends Controller
{
    public function index()
    {
        $delayreasons = Delayreason::with('mloblinformation.mlofeederInformation', 'mloblinformation.principal')
                        ->when(request('bolreference'), function($q){
                          $q->whereHas('mloblinformation', function($query){
                              $query->where('bolreference', request('bolreference'));
                          });
                        })->latest()->paginate(100);
        return view('mlo.delayreasons.index', compact('delayreasons'));
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $delayreasonData = $request->only('mloblinformation_id', 'reason', 'noted_date');
        $delayreasonData['noted_by'] = auth()->id();
        try{
            Delayreason::create($delayreasonData);
            return redirect()->route('delayreasons.index')->with('message','Reason Added Successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function show(Delayreason $delayreason)
    {
        //
    }


    public function edit(Delayreason $delayreason)
    {
        $formType = 'edit';
        $blinformation = Mloblinformation::with('mlofeederInformation', 'principal')
            ->where('id', $delayreason->mloblinformation_id)
            ->firstOrFail();
        return view('mlo.delayreasons.create', compact('formType', 'blinformation', 'delayreason'));
    }


    public function update(Request $request, Delayreason $delayreason)
    {
        $delayreasonData = $request->only('reason', 'noted_date');
        $delayreasonData['noted_by'] = auth()->id();
        try{
            $delayreason->update($delayreasonData);
            return redirect()->route('delayreasons.index')->with('message','Reason Updated Successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy(Delayreason $delayreason)
    {
        try{
            $delayreason->delete();
            return redirect()->route('delayreasons.index')->with('message','Reason Deleted Successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function blDelayNote($mloblinformation_id)
    {
        $formType = 'create';
        $blinformation = Mloblinformation::with('mlofeederInformation', 'principal')->where('id', $mloblinformation_id)->firstOrFail();
        return view('mlo.delayreasons.create', compact('formType', 'blinformation'));
    }

}
