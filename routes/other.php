<?php
  Route::get('apple-app-site-association', function() {
    return response()->json([
        'applinks' => [
            'apps'=>[],
            'details'=>[
              [
                'appID'=>'FUAJDLJ2V9.id.or.pmidkijakarta.pmi.ios',
                'paths'=>['*'],
              ]
            ]
        ]
    ]);
});