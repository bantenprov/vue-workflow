<?php



Route::group(['prefix' => 'vue-workflow', 'middleware' => ['web','auth:api']], function() {
    Route::get('demo', 'Bantenprov\VueWorkflow\Http\Controllers\VueWorkflowController@demo');

    // Route state

    /**
     * @url vue-workflow/state
     * 
     * @method GET
     */
    Route::get('/state','Bantenprov\VueWorkflow\Http\Controllers\StateController@index')->name('state.index');
    /**
     * @url vue-workflow/state/state
     * 
     * @method GET
     */
    Route::get('/state/create','Bantenprov\VueWorkflow\Http\Controllers\StateController@create')->name('state.create');
    /**
     * @url vue-workflow/state/$id/edit
     * @param id
     * 
     * @method GET
     */
    Route::get('/state/{id}/edit','Bantenprov\VueWorkflow\Http\Controllers\StateController@edit')->name('state.edit');
    /**
     * @url vue-workflow/state/$id/destroy
     * @param id
     * 
     * @method DELETE
     */
    Route::delete('/state/{id}/destroy','Bantenprov\VueWorkflow\Http\Controllers\StateController@destroy')->name('state.destroy');
    /**
     * @url vue-workflow/state/store
     * 
     * @method POST
     */
    Route::post('/state/store','Bantenprov\VueWorkflow\Http\Controllers\StateController@store')->name('state.store');
    /**
     * @url vue-workflow/state/$id/update
     * 
     * @method PUT
     */
    Route::put('/state/{id}/update','Bantenprov\VueWorkflow\Http\Controllers\StateController@update')->name('state.update');


    // Route transition

    /**
     * @url vue-workflow/transition
     * 
     * @method GET
     */
    Route::get('/transition','Bantenprov\VueWorkflow\Http\Controllers\TransitionController@index')->name('transition.index');
    /**
     * @url vue-workflow/transition/create
     * 
     * @method GET
     */
    Route::get('/transition/create','Bantenprov\VueWorkflow\Http\Controllers\TransitionController@create')->name('transition.create');
    /**
     * @url vue-workflow/transition/create/{id}/get-state
     * 
     * @method GET
     */
    Route::get('/transition/create/{id}/get-state','Bantenprov\VueWorkflow\Http\Controllers\TransitionController@getWorkflowState')->name('transition.getWorkflowState');
    /**
     * @url vue-workflow/transition/store
     * 
     * @method GET
     */
    Route::post('/transition/store','Bantenprov\VueWorkflow\Http\Controllers\TransitionController@store')->name('transition.store');
    /**
     * @url vue-workflow/transition/$id/edit
     * @param id
     * 
     * @method GET
     */
    Route::get('/transition/{id}/edit','Bantenprov\VueWorkflow\Http\Controllers\TransitionController@edit')->name('transition.edit');
    /**
     * @url vue-workflow/transition/$id/update
     * 
     * @method PUT
     */
    Route::put('/transition/{id}/update','Bantenprov\VueWorkflow\Http\Controllers\TransitionController@update')->name('transition.update');
    /**
     * @url vue-workflow/state/$id/destroy
     * @param id
     * 
     * @method DELETE
     */
    Route::delete('/transition/{id}/destroy','Bantenprov\VueWorkflow\Http\Controllers\TransitionController@destroy')->name('transition.destroy');
    /**
     * @url vue-workflow/workflow/
     * @param
     * 
     * @method GET
     */
    Route::get('/workflow','Bantenprov\VueWorkflow\Http\Controllers\WorkflowController@index')->name('workflow.index');
    /**
     * @url vue-workflow/workflow/create
     * @param
     * 
     * @method GET
     */
    Route::get('/workflow/create','Bantenprov\VueWorkflow\Http\Controllers\WorkflowController@create')->name('workflow.create');
    /**
     * @url vue-workflow/workflow/{id}/show
     * @param $id
     * 
     * @method GET
     */
    Route::get('/workflow/{id}/show','Bantenprov\VueWorkflow\Http\Controllers\WorkflowController@show')->name('workflow.show');
    /**
     * @url vue-workflow/workflow/{id}/edit
     * @param
     * 
     * @method GET
     */
    Route::get('/workflow/{id}/edit','Bantenprov\VueWorkflow\Http\Controllers\WorkflowController@edit')->name('workflow.edit');
    /**
     * @url vue-workflow/workflow/{id}/update
     * @param
     * 
     * @method PUT
     */
    Route::put('/workflow/{id}/update','Bantenprov\VueWorkflow\Http\Controllers\WorkflowController@update')->name('workflow.update');
    /**
     * @url vue-workflow/workflow/store
     * @param
     * 
     * @method POST
     */
    Route::post('/workflow/store','Bantenprov\VueWorkflow\Http\Controllers\WorkflowController@store')->name('workflow.store');
    /**
     * @url vue-workflow/workflow/store
     * @param
     * 
     * @method POST
     */
    Route::post('/workflow/{id}/store-workflow/','Bantenprov\VueWorkflow\Http\Controllers\WorkflowController@storeWorkflow')->name('workflow.storeWorkflow');
    /**
     * @url vue-workflow/state/$id/destroy
     * @param id
     * 
     * @method DELETE
     */
    Route::delete('/workflow/{id}/destroy','Bantenprov\VueWorkflow\Http\Controllers\WorkflowController@destroy')->name('workflow.destroy');


    Route::get('/workflow-process/{content_type}/{content_id}','Bantenprov\VueWorkflow\Http\Controllers\WorkflowProcessController@availableState')->name('workflow.process');

    Route::post('/workflow-process/change-state/{content_id}','Bantenprov\VueWorkflow\Http\Controllers\WorkflowProcessController@changeState')->name('workflow.changeState');

    Route::get('/workflow-process/get-history/{content_type}/{content_id}','Bantenprov\VueWorkflow\Http\Controllers\WorkflowProcessController@getAllHistoryThisContent')->name('workflow.getAllHistoryThisContent');

});
