<?php namespace iWedmak\StreamSearch;

use iWedmak\ExtraCurl;

class Search 
{

    public static function url($url_template, $str, $page=0)
    {
        $string=urlencode(str_replace( array( '\'', '"', ',', "'", "!" , ';', '<', '>', ')', '(', '.'), '', $str));
        if($page>=1)
        {
            $search_string = str_replace("{searchString}", $string, $url_template);
            $search_string = str_replace("{page}", $page, $search_string);
        }
        else
        {
            $search_string = str_replace("{searchString}", $string, $url_template);
        }
        return $search_string;
    }
    
    public static function makeRes($source, $url, $title, $poster=false, $duration=false, $file=false, $screen_map=false, $views=false, $uploaded=false)
    {
        $array['source']=$source;
        $array['url']=trim($url);
        $array['title']=trim($title);
        $array['poster']=trim($poster);
        $array['duration']=trim($duration);
        $array['file']=trim($file);
        $array['screen_map']=trim($screen_map);
        $array['views']=trim($views);
        $array['uploaded']=trim($uploaded);
        return $array;
    }
    
    public static function makeError($client)
    {
        $array=[
                'error_code'=>$client->c->error_code, 
                'error'=>$client->c->error, 
                'response_headers'=>$client->c->response_headers,
            ];
        return $array;
    }
    
}
?>