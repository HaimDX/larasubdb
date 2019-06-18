<?php

namespace HaimDX\LaraSubDB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaraSubDBController extends Controller
{
    //function to check connectivity to SUB DB
    public function checkSubDBConnectivity(){
        if (\SubDBHelper::checkSubDBConnectivity()){
            echo 'SUB DB connectivity successful';
        }

    }

    //function to setup params. e.g. allowed file formats
    public function iniParams(){

    }

    //function to search for new subtitle
    public function searchForSubtitleByMovieName($moviename){

    }
}
