<?php


Route::group(['middleware' => ['auth', 'preventBackHistory']], function () {



    //Fetch Data
    Route::get('/loadMLOExporterInfo/{name}', 'MLO\CommonDataController@loadMLOExporterInfo');

    //Auto Suggest / Complete
    Route::post('/feederNameAutoComplete', 'MLO\CommonDataController@feederNameAutoComplete')->name('feederNameAutoComplete');
    Route::get('/voyageAutoComplete/{vesselname}', 'MLO\CommonDataController@voyageAutoComplete')->name('voyageAutoComplete');
    Route::post('/rotationNoAutoComplete', 'MLO\CommonDataController@rotationNoAutoComplete')->name('rotationNoAutoComplete');


    Route::post('/bolreferenceAutoComplete', 'MLO\CommonDataController@bolreferenceAutoComplete')->name('bolreferenceAutoComplete');
    Route::post('/egmbolreferenceAutoComplete','MLO\CommonDataController@egmbolreferenceAutoComplete')->name('egmbolreferenceAutoComplete');



    //MLO Feeder Extra Controller
    Route::get("feederinformations/{feeder}/restore", 'MLO\FeederinformationController@restore');
    Route::get("feederinformations/{feeder_id}/forceDelete", 'MLO\FeederinformationController@forceDelete');
    Route::get('feederinformations/trashed', 'MLO\FeederinformationController@trashed')->name('trashfeeder');

    Route::get('egmfeederListForCustomUpdate', 'EgmMloMoneyReceiptController@feederListForCustomUpdate');
    Route::post('egmfeederCustomUpdate', 'EgmMloMoneyReceiptController@feederCustomUpdate');


    //MLO Bl Extra Controller
    Route::get('/mloblinformations/getFeederInfo/{vesselName}/{voyage}', 'MLO\MloblinformationController@getIgmByIgmNo');
    Route::get('/getBLMloname/{mlocode}', 'MLO\MloblinformationController@getMloNameByMloCode');

    Route::get('loadBlInfoByBolRef/{bolreference?}', 'MLO\MloblinformationController@loadBlInfoByBolRef')->where('bolreference', '(.*)')->name('loadBlInfoByBolRef');

    Route::get('checkMLOFCLContainer/{feeder_id}/{currentStatus}', 'MLO\MloblinformationController@checkMLOFCLContainer')->name('checkMLOFCLContainer'); //check FCL Container in Same IGM.


    //MLO Money Receipt Extra Controller
    Route::get('getEgmBLInfo/{bol?}', 'EgmMloMoneyReceiptController@getBLInfo')->where('bol', '(.*)');
    Route::get('egmmlomrreport', 'EgmMloMoneyReceiptController@mlomrreport')->name('egmmlomrreport');



    Route::get('egmBlEntryByFeeder/{feederID}', 'EgmMloblinformationController@blEntryByFeeder');

    //Deliver Order Extra Methods
    Route::get('getEgmMloBlInfo/{bolRef?}', 'EgmMloDeliveryorderController@getMloBlInfoByBolref')->where('bolRef', '(.*)');



    Route::get('egmMloDoPDF/{id}', 'EgmMloDeliveryorderController@mloDoPDF')->name('mloDoPDF');
    Route::get('egmMloDoReport', 'EgmMloDeliveryorderController@mloDoReport')->name('egmMloDoReport');


    //MlO Reports Route From Here..
    Route::get('egmcommitmentPDF', 'EgmMLOReportController@commitmentPDF')->name('egmcommitmentPDF');

    Route::get('egmMloprintAllBLByFeederID/{feederID}/{status}', 'EgmMLOReportController@printAllBLByFeederID')->name('egmMloprintAllBLByFeederID');

    Route::get('egmMlofeederinformations/{feeder_id}/ioccontainerlist', 'EgmMLOReportController@ioccontainerlist');
    Route::get('feederinformations/{feeder_id}/permissionPDF', 'EgmMLOReportController@permissionPDF')->name('permissionPDF');
    Route::get('feederinformations/{feeder_id}/permissionBengaliPDF', 'EgmMLOReportController@permissionBengaliPDF')->name('permissionBengaliPDF');
    Route::get('egmMlofeederinformations/{feeder_id}/lclContainerList', 'EgmMLOReportController@lclContainerList')->name('lclContainerList');
    Route::get('egmMlofeederinformations/{feeder_id}/inboundContainerList', 'EgmMLOReportController@inboundContainerList')->name('inboundContainerList');
    Route::get('egmMlofeederinformations/{feeder_id}/arrivalNoticePDF', 'EgmMLOReportController@arrivalNoticePDF')->name('arrivalNoticePDF');

    Route::get('egmMloinboundPerformanceReport/', 'EgmMLOReportController@inboundPerformanceReport')->name('egmMloinboundPerformanceReport');
    Route::get('mloMoneyReceiptPdf/{mrid}', 'MLO\MoneyReceiptController@mloMoneyReceiptPdf')->name('mloMoneyReceiptPdf');
    Route::get('getRotationNoReport/{vesselName}', 'MLO\MLOReportController@getRotationNoReport')->name('getRotationNoReport');
    Route::get('egmMloladenReport', 'EgmMLOReportController@ladenReport')->name('egmMloladenReport');


    Route::get('blDelayNote/{mloblinformation_id}', 'MLO\DelayreasonController@blDelayNote');


    Route::resources([
        'egmfeederinformations' => 'EgmFeederinformationController',
        'egmmlomoneyreceipts' => 'EgmMloMoneyReceiptController',
        'egmmlodeliveryorders' => 'EgmMloDeliveryorderController',
    ]);

    Route::resource('egmmloblinformations', 'EgmMloblinformationController')->except(['create']);
    Route::resource('delayreasons', 'MLO\DelayreasonController')->except(['create']);

    Route::post('/loadCnfClientNameAutoComplete', 'JsonDataController@loadCnfClientNameAutoComplete')->name('loadCnfClientNameAutoComplete');
    Route::post('/loadMasterPrincipalAutoComplete', 'JsonDataController@loadMasterPrincipalAutoComplete')->name('loadMasterPrincipalAutoComplete');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('egmMloblxmldownload/{feeder_id}', 'EgmMLOReportController@searcblforigmxml')->name('egmMloblxmldownload');
    Route::get('egmMlofeederinformations/{feeder_id}/containerList', 'EgmMLOReportController@containerList');
    Route::get('egmMloDoContainerReport', 'EgmMloDeliveryorderController@egmMloDoContainerReport')->name('egmMloDoContainerReport');
});
