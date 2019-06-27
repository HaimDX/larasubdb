<?php


namespace haimdx\larasubdb\Services;
use Ixudra\Curl\Facades\Curl;

class LaraSubDB
{
    public function dump()
    {
        dd( ('Laravel SUB DB API INTEGRATION LIBRARY By ANASS ARAKIA') );
    }

    /*
     * return the hash value of a movie file
     */
    private static function getSubDBHash($movie_name){

        if( is_null($movie_name) || empty($movie_name)){
            return 'provide input!';
        }

        //get path
        $movie = new \Symfony\Component\HttpFoundation\File\File($movie_name);

        //get the hash
        $size = filesize($movie);
        $content = file_get_contents($movie, false, null, 0, 64 * 1024);
        $fim = file_get_contents($movie, false, null, $size - (64 * 1024), 64 * 1024);
        $data = $content . $fim;
        $hash = md5($data);

        return $hash;
    }


    /*
     * search for subtitle in sub db
     * @input String movie name
     * @return array of supported languages
     */
    public static function searchSubDBForSubtitle($hash){
        //get url from config
        $api_url = config('main.api_url','http://api.thesubdb.com/');
        $action = "search";        //make curl request and get the subtitle
        $subtitle = Curl::to($api_url."?action=".$action."&hash=".$hash)
             ->withOption('USERAGENT','SubDB/1.0 (PHPSubDB 0.1; http://github.com/)')
             ->withOption('RETURNTRANSFER', true)
             ->enableDebug('larasubdd_logfile.txt')
             ->get();

         return $subtitle;
    }

    public static function downloadsubtitle($hash,$language){

        $api_url = config('main.api_url','http://api.thesubdb.com/');
        $action = "download";
        $subtitle = Curl::to($api_url."?action=".$action."&hash=".$hash."&language=".$language)
            ->withOption('USERAGENT','SubDB/1.0 (PHPSubDB 0.1; http://github.com/)')
            ->withOption('RETURNTRANSFER', true)
            ->enableDebug('larasubdd_logfile.txt')
            ->get();
        return $subtitle;

    }

    public static function searchAndDownload($movie_name,$language){
        //get hash
        $hash = LaraSubDB::getSubDBHash($movie_name);
        //search for available subtitle
        $available_languages = LaraSubDB::searchSubDBForSubtitle($hash);
        //check if requested language exist in the result
        $available_languages = explode(',',$available_languages);
        if( in_array($language,$available_languages)){
            //download the subtitle
            return LaraSubDB::downloadsubtitle($hash,$language);
        }else{
            return "Requested language not found";
        }

    }

}