<?php namespace iWedmak\StreamSearch;

use iWedmak\ExtraCurl\Parser;

class VodLocker implements StreamSearchInterface 
{

    public static function page($url, $cache=5, $client=false)
    {
        if(!$client)
        {
            $client=new Parser;
        }
        $client->setAgent('mobile');
        if($resp=$client->get($url, $cache))
        {
            $html=new \Htmldom;
            $html->str_get_html($resp);
            $stream=Search::makeRes
                (
                    'VodLocker', 
                    $url, 
                    $html->find('td#file_title', 0)->plaintext, 
                    @$html->find('video', 0)->attr['poster'], 
                    @$html->find('video source', 0)->attr['src']
                );
            return $stream;
        }
        return Search::makeError($client);
        
    }
    
    public static function search($url, $cache=5, $client=false)
    {
        if(!$client)
        {
            $client=new Parser;
        }
        $client->setAgent('mobile');
        if($resp=$client->get($url, $cache))
        {
            $html=new \Htmldom;
            $html->str_get_html($resp);
            $result=[];
            foreach($html->find('table.vlist tr') as $tr)
            {
                preg_match("/\((.*?)\)/", $tr->find('a', 0)->attr['style'], $match);
                preg_match("/\/([a-zA-Z0-9\_]*)\.([a-zA-Z0-9]{3})$/", $match[1], $img);
                $poster=$match[1];
                $pre=explode('_t',$img[0]);
                $screen_map=$pre[0].'0000'.$pre[1];
                list($days, $views)=explode('|',$tr->find('td', 1)->find('div[!class]', 0)->plaintext);
                $result[]=Search::makeRes
                    (
                        'VodLocker', 
                        $tr->find('a', 0)->attr['href'], 
                        $tr->find('div.link', 0)->plaintext, 
                        $poster, 
                        $tr->find('span', 0)->plaintext, 
                        false, 
                        str_replace($img[0], $screen_map, $poster),
                        filter_var($views, FILTER_SANITIZE_NUMBER_INT),
                        filter_var($days, FILTER_SANITIZE_NUMBER_INT)
                    );
            }
            return $result;
        }
        return Search::makeError($client);
    }
    
}
?>