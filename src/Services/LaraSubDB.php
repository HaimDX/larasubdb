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
    private static function getSubDBHash($movie_path){

        if( is_null($movie_path) || empty($movie_path)){
            return 'provide input!';
        }

        //get path
        $movie = new \Symfony\Component\HttpFoundation\File\File($movie_path);

        //get the hash
        $size = filesize($movie);
        $content = file_get_contents($movie, false, null, 0, 64 * 1024);
        $fim = file_get_contents($movie, false, null, $size - (64 * 1024), 64 * 1024);
        $data = $content . $fim;
        $hash = md5($data);

        return $hash;
    }

    /*
     * search at SUB DB and return download URL for the subtitle
     */
    public static function searchSubDBForSubtitle($movie_path){

        //get movie hash
        $hash = LaraSubDB::getSubDBHash($movie_path);
        //get url from config
        $api_url = config('main.api_url','http://api.thesubdb.com/?action=search');
        //make curl request and get the subtitle
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "SubDB/1.0 (PHPSubDB 0.1; http://github.com/)");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $api_url."&hash=".$hash);
        $subtitle = curl_exec($ch);
        unset($ch);
        dd($subtitle);


    }

    /*
     * rewrite using isudra CURL ext for Laravel
     */
    public static function searchSubDBForSubtitlev2($movie_path){
        //get movie hash
        $hash = LaraSubDB::getSubDBHash($movie_path);
        //get url from config
        $api_url = config('main.api_url','http://api.thesubdb.com/?action=search');
        //make curl request and get the subtitle
         $subtitle = Curl::to($api_url."&hash=".$hash)
             ->withOption('USERAGENT','SubDB/1.0 (PHPSubDB 0.1; http://github.com/)')
             ->withOption('RETURNTRANSFER', true)
             ->enableDebug('larasubdd_logfile.txt')
             ->get();
         dd($subtitle);
    }


}