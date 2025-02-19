<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(['register' => false]);

Route::group(['middleware'=>['auth', 'preventBackHistory']], function(){

    Route::get('/', 'HomeController@home')->name('home');

    //redirect to igm dashboard
    Route::get('/igm-dashboard', 'HomeController@igmDashboard')->name('igm-dashboard');

    Route::view('change-password','users.changePassword')->name('change-password');
    Route::post('updatePassword','ChangePasswordController@updatePassword')->name('updatePassword');


    Route::get('downloadofcnameExcel', 'OfficenameController@downloadExcel')->name('officenameexcel');
    Route::post('importofcnameExcel', 'OfficenameController@importExcel')->name('importofficename');


    //Masterbl Extra Controler
    Route::get('/trashmaster', 'MasterblController@mblTrash')->name('trashmaster');
    Route::get('/trashmblrestore/{id}', 'MasterblController@mblRestore')->name('mblrestore');
    Route::post('updateMasterRotBerthing', 'MasterblController@updateMasterRotBerthing');
    Route::get('/getMloname/{mlocode}', 'MasterblController@getMloNameByMloCode');
    Route::get('vesselpositioning', 'MasterblController@vesselpositioning')->name('vesselpositioning');
    Route::get('masterbls/unstaffingSheet/{id}', 'MasterblController@unstaffingSheet');

    Route::get('cloneMasterblById/{id}', 'MasterblController@cloneMasterblById');



    Route::post('importVatRegsExcel', 'VatregController@importVatRegsExcel')->name('importVatRegsExcel');
    Route::post('import', 'LocationController@import')->name('import');

    Route::get('printhousebl', 'HouseblController@printhousebl');


    Route::view('houseblstatus','housebls.houseblstatus')->name('houseblstatus');
    Route::post('houseblstatusPDF','HouseblController@houseblstatusPDF')->name('houseblstatusPDF');

    Route::get('loadHouseByBolRef/{bolRef?}', 'HouseblController@loadHouseByBolRef')->where('bolRef', '(.*)')->name('loadHouseByBolRef');

    Route::get('checkFCLContainer/{igmno}/{currentStatus}','HouseblController@checkFCLContainer')->name('checkFCLContainer');//check FCL Container in Same IGM.

    Route::post('/loadHouseblIgmAutoComplete','JsonDataController@loadHouseblIgmAutoComplete')->name('loadHouseblIgmAutoComplete');
    Route::post('/loadHouseblMblNoAutoComplete','JsonDataController@loadHouseblMblNoAutoComplete')->name('loadHouseblMblNoAutoComplete');
    Route::post('/loadHouseblBolreferenceAutoComplete','JsonDataController@loadHouseblBolreferenceAutoComplete')->name('loadHouseblBolreferenceAutoComplete');
    Route::post('/loadHouseblContainerAutoComplete','JsonDataController@loadHouseblContainerAutoComplete')->name('loadHouseblContainerAutoComplete');
    Route::post('/loadHouseblNotifyNameAutoComplete','JsonDataController@loadHouseblNotifyNameAutoComplete')->name('loadHouseblNotifyNameAutoComplete');
    Route::post('/loadHouseblDescriptionAutoComplete','JsonDataController@loadHouseblDescriptionAutoComplete')->name('loadHouseblDescriptionAutoComplete');
    Route::post('/loadHouseblExporternameAutoComplete','JsonDataController@loadHouseblExporternameAutoComplete')->name('loadHouseblExporternameAutoComplete');
    Route::post('/loadHouseblMotherVesselAutoComplete','JsonDataController@loadHouseblMotherVesselAutoComplete')->name('loadHouseblMotherVesselAutoComplete');
    Route::post('/loadHouseblFeederVesselAutoComplete','JsonDataController@loadHouseblFeederVesselAutoComplete')->name('loadHouseblFeederVesselAutoComplete');
    Route::post('/loadMasterPrincipalAutoComplete','JsonDataController@loadMasterPrincipalAutoComplete')->name('loadMasterPrincipalAutoComplete');
    Route::post('/loadCnfClientNameAutoComplete','JsonDataController@loadCnfClientNameAutoComplete')->name('loadCnfClientNameAutoComplete');
    Route::get('/loadHouseblVoyage/{vesselname}','JsonDataController@loadHouseblVoyage')->name('loadHouseblVoyage');
    Route::post('/principalAutoComplete','JsonDataController@principalAutoComplete')->name('principalAutoComplete');

    Route::get('/getPrincipalDataByName/{principalName}','JsonDataController@getPrincipalDataByName')->name('getPrincipalDataByName');


    Route::get('searchhouseblcontainersForm', 'HouseblController@searchHouseblContainersForm')->name('searchhouseblcontainersForm');

    Route::get('searchhouseblcontainers', 'HouseblController@searchHouseblContainers')->name('searchhouseblcontainers');
    Route::post('containersBulkUpdate', 'HouseblController@containersBulkUpdate')->name('containersBulkUpdate');


    Route::get('/getIgm/{igmno}', 'HouseblController@getIgmByIgmNo');
    Route::get('/getIgmByMbl/{mblno}', 'HouseblController@getIgmByMblNo');



    Route::post('packageimport', 'PackageController@import')->name('packageimport');
    Route::get('/getPackageName/{packagecode}', 'JsonDataController@getPackageNameByPackageCode');

    Route::post('containertypeimport', 'ContainertypeController@import')->name('containerimport');
    Route::post('commodityimport', 'CommodityController@import')->name('commodityimport');
    Route::post('offdockimport', 'OffdockController@import')->name('offdockimport');
//    Route::get('downloadreports', 'HouseblController@downloadReports')->name('downloadreports');


    Route::get('emptyMoneyReceipts', 'MoneyreceiptController@emptyMoneyReceipts')->name('emptyMoneyReceipts');


    Route::get('mrreport', 'MoneyreceiptController@mrreport')->name('mrreport');

    Route::post('cnfagentimport', 'CnfagentController@import')->name('cnfagentimport');

    Route::get('/getHouseBlinfo/{bolreference?}', 'MoneyreceiptController@getHouseBlinfo')->where('bolreference', '(.*)');
    Route::get('mrPdf/{mrid}', 'MoneyreceiptController@mrPDF')->name('mrPdf');

    Route::get('doreport', 'DeliveryorderController@doreport')->name('doreport');


    Route::get('/getHBLid/{hblno?}', 'DeliveryorderController@getHouseBlbyId')->where('hblno', '(.*)');


    Route::get('doPdf/{doid}', 'DeliveryorderController@doPDF')->name('doPdf');
    Route::get('hblPdf/{hblid}', 'HouseblController@hblPdf')->name('hblPdf');


    //Reports Routes
    Route::get('deliveryOrder', function(){return view('housebls.reports');})->name('deliveryOrder');
//    Route::get('searchFrdLetter', function(){return view('housebls.reports');})->name('searchFrdLetter');
    Route::get('searchFrdLetter', 'HouseblController@searchFrdLetter')->name('searchFrdLetter');
    Route::get('extensionLetter', 'HouseblController@extensionLetter')->name('extensionLetter');
    Route::get('eDeliverySearch', function(){return view('housebls.reports');})->name('eDeliverySearch');
    Route::get('mailList', 'HouseblController@mailList')->name('mailList');
    Route::post('extensionLetterData', 'HouseblController@extensionLetterData')->name('extensionLetterData');

    Route::get('onChassisLetter', 'HouseblController@onChassisLetter')->name('onChassisLetter');
    Route::post('onChassisLetterData', 'HouseblController@onChassisLetterData')->name('onChassisLetterData');


    Route::get('submitsearchigmforpdf', 'HouseblController@searchresultforigmpdf')->name('submitsearchigmforpdf');
    Route::get('masterbls/arrivalNotice/{igm}', 'HouseblController@arrivalNoticepdf')->name('arrivalNoticepdf');

    Route::post('frdLetter', 'HouseblController@frdLetter')->name('frdLetter');

    Route::get('containerExtension/{mlono}', 'JsonDataController@containerExtension')->name('containerExtension');
    Route::get('containerExtensionByBolRef/{bolref?}', 'JsonDataController@containerExtensionByBolRef')
        ->where('bolref', '(.*)')->name('containerExtensionByBolRef');

    Route::get('eDeliveryData/', 'HouseblController@eDeliveryData')->name('eDeliveryData');


    //json Route From Here..
    Route::post('/loadPortDataAutoComplete','JsonDataController@loadPortDataAutoComplete')->name('loadPortDataAutoComplete');
    Route::get('/loadExporterInfo/{name}', 'JsonDataController@loadExporterAddress');
    Route::get('/loadPortData/{portName}', 'JsonDataController@loadPortData');
    Route::get('/getBin/{bin}', 'JsonDataController@getBinByBinNo');
    Route::get('/getBinByName/{name}', 'JsonDataController@getBinByName');

    Route::post('/binDataByNameAutoComplete', 'JsonDataController@binDataByNameAutoComplete')->name('binDataByNameAutoComplete');
    Route::post('/loadCountryByNameAutoComplete', 'JsonDataController@loadCountryByNameAutoComplete')->name('loadCountryByNameAutoComplete');
    Route::get('/loadCountryByIso/{iso}', 'JsonDataController@loadCountryByIso')->name('loadCountryByIso');


    //C-Tracking From Here..
    Route::get('/ctrack', 'Ctrack\IndexController@index')->name('indexctrack');

    Route::post('emptycontainers/bulkEdit', 'Ctrack\EmptyContainerController@bulkEdit')->name('emptyContainerBulkEdit');
    Route::get('searchContainer', 'Ctrack\EmptyContainerController@searchContainer')->name('searchContainer');
    Route::get('searchContainerByConRef', 'Ctrack\EmptyContainerController@searchContainerByConRef')->name('searchContainerByConRef');


    //Export Route
    Route::get('stfcontainerlist', 'Ctrack\ExportController@stfcontainerlist')->name('stfcontainerlist');


    Route::get('ctrack/doreport', 'Ctrack\ReportController@searchDoReport')->name('searchDoReport');
    Route::get('ctrack/containerReport', 'Ctrack\ReportController@containerReport')->name('containerReport');

    Route::get('containerStatus', 'Ctrack\ReportController@containerStatus')->name('containerStatus');
    Route::get('containerSummary', 'Ctrack\ReportController@containerSummary')->name('containerSummary');




    Route::resources([
        'permissions' => 'PermissionController',
        'roles' => 'RoleController',
        'users' => 'UserController',

        'offdocks' => 'OffdockController',
        'vatregs' => 'VatregController',
        'packages'=> 'PackageController',
        'locations' => 'LocationController',
        'containertypes' => 'ContainertypeController',
        'commoditys' => 'CommodityController',
        'officenames' => 'OfficenameController',
        'cnfagents' => 'CnfagentController',
        'descriptions' => 'DescriptionController',
        'principals' => 'PrincipalController',
        'moneyreceiptheads' => 'MoneyReceiptHeadController',

        'masterbls' => 'MasterblController',
        'housebls' => 'HouseblController',
        'moneyreceipts' => 'MoneyreceiptController',
        'deliveryorders' => 'DeliveryorderController',
    ]);
    Route::resource('exports', 'Ctrack\ExportController');
    Route::resource('emptycontainers', 'Ctrack\EmptyContainerController');
});

Route::group(['middleware'=>['auth']], function(){
    Route::get('masterbls/downloadXml/{id}', 'HouseblController@downloadXml')->name('downloadXml');

    Route::get('/doexport', 'DeliveryorderController@export');
});
