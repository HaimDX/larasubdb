<?php

Route::get('LaraSubDB', function(){
    echo 'Hello from the LARAVEL SUB DB API package!';
});

Route::get('LaraSubDB/checksubdbconnectivity','\haimdx\larasubdb\LaraSubDBController@checkSubDBConnectivity');

