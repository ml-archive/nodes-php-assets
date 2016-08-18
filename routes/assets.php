<?php
Route::group(['namespace' => 'Nodes\Assets\Http\Controllers', 'prefix' => 'cdn'], function() {
    Route::get('/{folder}/{file}', [
        'as' => 'nodes.assets.public_folder.cdn',
        'uses' => 'PublicFolderCdn@cdn',
    ]);
});
