<?php


Route::group(['middleware'=>['auth', 'preventBackHistory']], function(){



    //Fetch Data
    Route::get('/loadMLOExporterInfo/{name}', 'MLO\CommonDataController@loadMLOExporterInfo');

    //Auto Suggest / Complete
    Route::post('/feederNameAutoComplete', 'MLO\CommonDataController@feederNameAutoComplete')->name('feederNameAutoComplete');
    Route::get('/voyageAutoComplete/{vesselname}','MLO\CommonDataController@voyageAutoComplete')->name('voyageAutoComplete');
    Route::post('/rotationNoAutoComplete','MLO\CommonDataController@rotationNoAutoComplete')->name('rotationNoAutoComplete');
    Route::post('/bolreferenceAutoComplete','MLO\CommonDataController@bolreferenceAutoComplete')->name('bolreferenceAutoComplete');



    //MLO Feeder Extra Controller
    Route::get("feederinformations/{feeder}/restore", 'MLO\FeederinformationController@restore');
    Route::get("feederinformations/{feeder_id}/forceDelete", 'MLO\FeederinformationController@forceDelete');
    Route::get('feederinformations/trashed', 'MLO\FeederinformationController@trashed')->name('trashfeeder');

    Route::get('feederListForCustomUpdate', 'MLO\MoneyReceiptController@feederListForCustomUpdate');
    Route::post('feederCustomUpdate', 'MLO\MoneyReceiptController@feederCustomUpdate');


    //MLO Bl Extra Controller
    Route::get('/mloblinformations/getFeederInfo/{vesselName}/{voyage}', 'MLO\MloblinformationController@getIgmByIgmNo');
    Route::get('/getBLMloname/{mlocode}', 'MLO\MloblinformationController@getMloNameByMloCode');

    Route::get('loadBlInfoByBolRef/{bolreference?}', 'MLO\MloblinformationController@loadBlInfoByBolRef')->where('bolreference', '(.*)')->name('loadBlInfoByBolRef');

    Route::get('checkMLOFCLContainer/{feeder_id}/{currentStatus}','MLO\MloblinformationController@checkMLOFCLContainer')->name('checkMLOFCLContainer');//check FCL Container in Same IGM.


    //MLO Money Receipt Extra Controller
    Route::get('getBLInfo/{bol?}', 'MLO\MoneyReceiptController@getBLInfo')->where('bol', '(.*)');
    Route::get('mlomrreport', 'MLO\MoneyReceiptController@mlomrreport')->name('mlomrreport');



    Route::get('blEntryByFeeder/{feederID}', 'MLO\MloblinformationController@blEntryByFeeder');

    //Deliver Order Extra Methods
    Route::get('getMloBlInfo/{bolRef?}', 'MLO\DeliveryorderController@getMloBlInfoByBolref')->where('bolRef', '(.*)');



    Route::get('mloDoPDF/{id}', 'MLO\DeliveryorderController@mloDoPDF')->name('mloDoPDF');
    Route::get('mloDoReport', 'MLO\DeliveryorderController@mloDoReport')->name('mloDoReport');


    //MlO Reports Route From Here..
    Route::get('commitmentPDF', 'MLO\MLOReportController@commitmentPDF')->name('commitmentPDF');

    Route::get('printAllBLByFeederID/{feederID}/{status}', 'MLO\MLOReportController@printAllBLByFeederID')->name('printAllBLByFeederID');

    Route::get('feederinformations/{feeder_id}/ioccontainerlist', 'MLO\MLOReportController@ioccontainerlist');
    Route::get('feederinformations/{feeder_id}/permissionPDF', 'MLO\MLOReportController@permissionPDF')->name('permissionPDF');
    Route::get('feederinformations/{feeder_id}/permissionBengaliPDF', 'MLO\MLOReportController@permissionBengaliPDF')->name('permissionBengaliPDF');
    Route::get('feederinformations/{feeder_id}/lclContainerList', 'MLO\MLOReportController@lclContainerList')->name('lclContainerList');
    Route::get('feederinformations/{feeder_id}/inboundContainerList', 'MLO\MLOReportController@inboundContainerList')->name('inboundContainerList');
    Route::get('feederinformations/{feeder_id}/arrivalNoticePDF', 'MLO\MLOReportController@arrivalNoticePDF')->name('arrivalNoticePDF');

    Route::get('inboundPerformanceReport/', 'MLO\MLOReportController@inboundPerformanceReport')->name('inboundPerformanceReport');
    Route::get('mloMoneyReceiptPdf/{mrid}', 'MLO\MoneyReceiptController@mloMoneyReceiptPdf')->name('mloMoneyReceiptPdf');
    Route::get('getRotationNoReport/{vesselName}', 'MLO\MLOReportController@getRotationNoReport')->name('getRotationNoReport');
    Route::get('ladenReport', 'MLO\MLOReportController@ladenReport')->name('ladenReport');


    Route::get('blDelayNote/{mloblinformation_id}', 'MLO\DelayreasonController@blDelayNote');


    Route::resources([
        'feederinformations' => 'MLO\FeederinformationController',
        'mlomoneyreceipts' => 'MLO\MoneyReceiptController',
        'mlodeliveryorders' => 'MLO\DeliveryorderController',
    ]);

    Route::resource('mloblinformations', 'MLO\MloblinformationController')->except(['create']);
    Route::resource('delayreasons', 'MLO\DelayreasonController')->except(['create']);

});

Route::group(['middleware'=>['auth']], function(){
    Route::get('blxmldownload/{feeder_id}', 'MLO\MLOReportController@searcblforigmxml')->name('blxmldownload');
    Route::get('feederinformations/{feeder_id}/containerList', 'MLO\MLOReportController@containerList');
    Route::get('mloDoContainerReport', 'MLO\DeliveryorderController@mloDoContainerReport')->name('mloDoContainerReport');
});