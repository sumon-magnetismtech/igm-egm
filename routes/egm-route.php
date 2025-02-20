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

    Route::resources([
        'egmmasterbls' => 'EgmMasterBlController',
    ]);

});