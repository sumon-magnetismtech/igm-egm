<?php

namespace App\Http\Controllers\Ctrack;

use App\Ctrack\EmptyContainer;
use App\Ctrack\Export;
use App\ExportContainer;
use App\Http\Controllers\Controller;
use App\MLO\Blcontainer;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stfcontainerlist(Request $request)
    {
        if(!empty($request->contRef)){
            $searchedCont = $request->contRef;
            $containers = explode(' ', $searchedCont);
            $stfContainerList = Blcontainer::whereIn('contref', $containers)->where('containerStatus', 'stuffing')->orWhere('containerStatus', 'force load')->get();
        }else{
            $stfContainerList = Blcontainer::where('containerStatus', 'stuffing')->orWhere('containerStatus', 'force load')->get();
            $searchedCont = '';
        }
        return view('ctrack/exports.stfcontainerlist', compact('stfContainerList', 'searchedCont'));
    }


    public function index()
    {
        $exports = Export::paginate();
        return view('ctrack/exports.index', compact('exports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $contID = collect($request->id); //Bl Container Table id
        $containers = $contID->combine(collect($request->contRef)); //Bl Container Table ContRef
        $fromType = 'create';
        $eStatus = ['PRT','LCL','FCL','ETY'];
        return view('ctrack/exports.create', compact('containers', 'fromType', 'eStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $exportData = $request->except('exportDate', 'sailingDate','etaDate', 'blcontainer_id', 'contRef');
            $exportData['exportDate']= $request->exportDate !== null ? date('Y-m-d', strtotime(request('exportDate'))) : null;
            $exportData['sailingDate']= $request->sailingDate !== null ? date('Y-m-d', strtotime(request('sailingDate'))) : null;
            $exportData['etaDate']= $request->sailingDate !== null ? date('Y-m-d', strtotime(request('etaDate'))) : null;

            $export = Export::create($exportData);
            foreach($request->blcontainer_id as $key => $v) {
                $data = array(
                    'export_id' => $export->id,
                    'blcontainer_id' => $request->blcontainer_id[$key],
                    'contRef' => $request->contRef[$key],
                );
                ExportContainer::create($data);
            }
            Blcontainer::whereIn('id', $request->blcontainer_id)->update(['containerStatus'=>'out']);

            return redirect()->route('exports.index')->with('success','Exported successfully.');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function show(Export $export)
    {
        return view('ctrack/exports.show', compact('export'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function edit(Export $export)
    {
        $containers = ExportContainer::where('export_id', $export->id)->pluck('contRef', 'blcontainer_id'); //Bl Container Table ContRef
        $fromType = 'edit';
        $eStatus = ['PRT','LCL','FCL','ETY'];
        return view('ctrack/exports.create', compact('containers', 'fromType', 'export', 'eStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Export $export)
    {
        try{
            $exportData = $request->except('exportDate', 'sailingDate','etaDate', 'blcontainer_id', 'contRef');
            $exportData['exportDate']= $request->exportDate !== null ? date('Y-m-d', strtotime(request('exportDate'))) : null;
            $exportData['sailingDate']= $request->sailingDate !== null ? date('Y-m-d', strtotime(request('sailingDate'))) : null;
            $exportData['etaDate']= $request->sailingDate !== null ? date('Y-m-d', strtotime(request('etaDate'))) : null;

            $export->update($exportData);

            $oldExportContIds = $export->exportContainers()->pluck('blcontainer_id');
            $newExportContIds = $export->exportContainers()->whereIn('blcontainer_id', $request->blcontainer_id)->pluck('blcontainer_id');
            $diffData = $oldExportContIds->diff($newExportContIds);
            foreach($diffData as $diff){
                $status = EmptyContainer::where('id', $diff)->first();
                Blcontainer::where('id', $diff)->update(['containerStatus'=>$status->containerStatus]);
            }

            $export->exportContainers()->delete();

            foreach($request->blcontainer_id as $key => $v) {
                $data = array(
                    'export_id' => $export->id,
                    'blcontainer_id' => $request->blcontainer_id[$key],
                    'contRef' => $request->contRef[$key],
                );
                ExportContainer::create($data);
            }
            Blcontainer::whereIn('id', $request->blcontainer_id)->update(['containerStatus'=>'out']);

            return redirect()->route('exports.index')->with('success','Exported successfully.');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function destroy(Export $export)
    {
        try{
            $export->delete();
            return redirect()->route('exports.index')->with('success','Export Info Deleted Successfully.');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
