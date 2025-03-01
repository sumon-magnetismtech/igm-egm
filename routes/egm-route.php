<?php


Route::group(['middleware'=>['auth', 'preventBackHistory']], function(){

    //Masterbl Extra Controler
    Route::get('/egm-trashmaster', 'EgmMasterBlController@mblTrash')->name('egmtrashmaster');
    Route::get('/trashmblrestore/{id}', 'EgmMasterBlController@mblRestore')->name('mblrestore');
    Route::post('updateMasterRotBerthing', 'EgmMasterBlController@updateMasterRotBerthing');
    Route::get('/getMloname/{mlocode}', 'EgmMasterBlController@getMloNameByMloCode');
    Route::get('vesselpositioning', 'EgmMasterBlController@vesselpositioning')->name('vesselpositioning');
    Route::get('egmmasterbls/unstaffingSheet/{id}', 'EgmMasterBlController@unstaffingSheet');

    Route::get('egmCloneMasterblById/{id}', 'EgmMasterBlController@egmCloneMasterblById');

    Route::get('printhousebl', 'EgmHouseBlController@printhousebl');
    Route::view('egmhouseblstatus','egm.housebls.houseblstatus')->name('egmhouseblstatus');
    Route::post('egmhouseblstatusPDF','EgmHouseBlController@houseblstatusPDF')->name('egmhouseblstatusPDF');
    Route::get('loadHouseByBolRef/{bolRef?}', 'EgmHouseBlController@loadHouseByBolRef')->where('bolRef', '(.*)')->name('loadHouseByBolRef');

    Route::get('checkFCLContainer/{igmno}/{currentStatus}','EgmHouseBlController@checkFCLContainer')->name('checkFCLContainer');//check FCL Container in Same IGM.
    Route::get('egmsearchhouseblcontainersForm', 'EgmHouseBlController@searchHouseblContainersForm')->name('egmsearchhouseblcontainersForm');

    Route::get('egmsearchhouseblcontainers', 'EgmHouseBlController@searchHouseblContainers')->name('egmsearchhouseblcontainers');
    Route::post('egmcontainersBulkUpdate', 'EgmHouseBlController@containersBulkUpdate')->name('egmcontainersBulkUpdate');

    //Housebl Extra Controler
    Route::get('/getIgm/{igmno}', 'EgmHouseBlController@getIgmByIgmNo');
    Route::get('/getIgmByMbl/{mblno}', 'EgmHouseBlController@getIgmByMblNo');
    Route::get('hblPdf/{hblid}', 'EgmHouseBlController@hblPdf')->name('hblPdf');
    Route::get('searchFrdLetter', 'EgmHouseBlController@searchFrdLetter')->name('searchFrdLetter');
    Route::get('extensionLetter', 'EgmHouseBlController@extensionLetter')->name('extensionLetter');
    Route::get('mailList', 'EgmHouseBlController@mailList')->name('mailList');
    Route::post('extensionLetterData', 'EgmHouseBlController@extensionLetterData')->name('extensionLetterData');

    Route::get('onChassisLetter', 'EgmHouseBlController@onChassisLetter')->name('onChassisLetter');
    Route::post('onChassisLetterData', 'EgmHouseBlController@onChassisLetterData')->name('onChassisLetterData');


    Route::get('submitsearchigmforpdf', 'EgmHouseBlController@searchresultforigmpdf')->name('submitsearchigmforpdf');
    Route::get('masterbls/arrivalNotice/{igm}', 'EgmHouseBlController@arrivalNoticepdf')->name('arrivalNoticepdf');

    Route::post('frdLetter', 'EgmHouseBlController@frdLetter')->name('frdLetter');

    Route::get('eDeliveryData/', 'EgmHouseBlController@eDeliveryData')->name('eDeliveryData');

    Route::get('egmCheckFCLContainer/{igmno}/{currentStatus}','HouseblController@egmCheckFCLContainer')->name('egmCheckFCLContainer');//check FCL Container in Same IGM.

    //money receipt route
    Route::get('emptyMoneyReceipts', 'MoneyreceiptController@emptyMoneyReceipts')->name('emptyMoneyReceipts');


    Route::get('egmmrreport', 'EgmMoneyreceiptController@mrreport')->name('egmmrreport');

    Route::get('/getEgmHouseBlinfo/{bolreference?}', 'EgmMoneyreceiptController@getHouseBlinfo')->where('bolreference', '(.*)');
    Route::get('egmmrPdf/{mrid}', 'EgmMoneyreceiptController@mrPDF')->name('egmmrPdf');

    //json Route From Here..
    Route::post('/egmloadHouseblIgmAutoComplete','JsonDataController@egmLoadHouseblIgmAutoComplete')->name('egmLoadHouseblIgmAutoComplete');
    Route::post('/egmloadHouseblMblNoAutoComplete','JsonDataController@egmLoadHouseblMblNoAutoComplete')->name('egmLoadHouseblMblNoAutoComplete');
    Route::post('/egmloadHouseblBolreferenceAutoComplete','JsonDataController@egmLoadHouseblBolreferenceAutoComplete')->name('egmLoadHouseblBolreferenceAutoComplete');
    Route::post('/egmloadHouseblContainerAutoComplete','JsonDataController@egmLoadHouseblContainerAutoComplete')->name('egmLoadHouseblContainerAutoComplete');
    Route::post('/egmloadHouseblNotifyNameAutoComplete','JsonDataController@egmLoadHouseblNotifyNameAutoComplete')->name('egmLoadHouseblNotifyNameAutoComplete');
    Route::post('/egmloadHouseblDescriptionAutoComplete','JsonDataController@egmLoadHouseblDescriptionAutoComplete')->name('egmLoadHouseblDescriptionAutoComplete');
    Route::post('/egmloadHouseblExporternameAutoComplete','JsonDataController@egmLoadHouseblExporternameAutoComplete')->name('egmLoadHouseblExporternameAutoComplete');
    Route::post('/egmloadHouseblMotherVesselAutoComplete','JsonDataController@egmLoadHouseblMotherVesselAutoComplete')->name('egmLoadHouseblMotherVesselAutoComplete');
    Route::post('/egmloadHouseblFeederVesselAutoComplete','JsonDataController@egmLoadHouseblFeederVesselAutoComplete')->name('egmLoadHouseblFeederVesselAutoComplete');
    Route::post('/egmloadMasterPrincipalAutoComplete','JsonDataController@egmLoadMasterPrincipalAutoComplete')->name('egmLoadMasterPrincipalAutoComplete');
    Route::post('/egmloadCnfClientNameAutoComplete','JsonDataController@egmLoadCnfClientNameAutoComplete')->name('egmLoadCnfClientNameAutoComplete');
    Route::get('/egmloadHouseblVoyage/{vesselname}','JsonDataController@egmLoadHouseblVoyage')->name('egmLoadHouseblVoyage');


    Route::get('containerExtension/{mlono}', 'JsonDataController@egmContainerExtension')->name('egmContainerExtension');
    Route::get('containerExtensionByBolRef/{bolref?}', 'JsonDataController@egmContainerExtensionByBolRef');
    Route::get('/loadExporterInfo/{name}', 'JsonDataController@egmLoadExporterAddress');


    Route::resources([
        'egmmasterbls' => 'EgmMasterBlController',
        'egmmoneyreceiptheads' => 'MoneyReceiptHeadController',
        'egmhousebls' => 'EgmHouseBlController',
        'egmmoneyreceipts' => 'EgmMoneyreceiptController',
        'egmdeliveryorders' => 'DeliveryorderController',
    ]);

    Route::group(['middleware'=>['auth']], function(){
        Route::get('masterbls/downloadXml/{id}', 'EgmHouseBlController@downloadXml')->name('downloadXml');
    
        Route::get('/doexport', 'DeliveryorderController@export');
    });

});