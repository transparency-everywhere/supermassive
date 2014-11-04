<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of class_cms
 *
 * @author Transparency Everywhere
 */
include('functions.php');

function getBasePathFromUrl($url){
    $url_info = parse_url($url);
    return $url_info['host'];
}

function curler($url){
    $c = curl_init($url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt(... other options you want...)

    $html = curl_exec($c);

    // Get the status code
    $status = curl_getinfo($c, CURLINFO_HTTP_CODE);
    
    return array('html'=>$html, 'status'=>$status);
}

function rel2abs($rel, $base)
{   
    $scheme = 'http';
    /* return if already absolute URL */
    if (parse_url($rel, PHP_URL_SCHEME) != '') return $rel;

    
    
    /* queries and anchors */
    if ($rel[0]=='#' || $rel[0]=='?') return $base.$rel;
    
    if(substr($rel, 0, 1) == '/'){
        $rel = substr($rel, 1);
    }

    /* parse base URL and convert to local variables:
       $scheme, $host, $path */
    extract(parse_url($base));

    /* remove non-directory element from path */
    $path = preg_replace('#/[^/]*$#', '', $path);

    /* destroy path if relative url points to root */
    if ($rel[0] == '/') $path = '';

    /* dirty absolute URL */
    $abs = "$host$path/$rel";

    /* replace '//' or '/./' or '/foo/../' with '/' */
    $re = array('#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#');
    for($n=1; $n>0; $abs=preg_replace($re, '/', $abs, -1, $n)) {}

    /* absolute URL is ready! */
    return $scheme.'://'.$abs;
}

function is_absolute_patha($path) {
    if(filter_var($path, FILTER_VALIDATE_URL))
        return 1;
    else
        return 0;
}


function getURLHost($url){
    $urlData = parse_url($url);
    return $urlData['host'];
}

class Crawler {

protected $markup = '';

public function __construct($uri) {

$this->markup = $this->getMarkup($uri);

}

public function getMarkup($uri) {

return file_get_contents($uri);

}

public function get($type) {

$method = "_get_{$type}";

if (method_exists($this, $method)){

return call_user_method($method, $this);

}

}

protected function _get_images() {

if (!empty($this->markup)){

preg_match_all('/<img([^>]+)\/>/i', $this->markup, $images);

return !empty($images[1]) ? $images[1] : FALSE;

}

}

protected function _get_links() {

if (!empty($this->markup)){

preg_match_all('/<a([^>]+)\>(.*?)\<\/a\>/i', $this->markup, $links);

return !empty($links[1]) ? $links[1] : FALSE;

}

}

public function crawlWebsiteLinks($link, $crawledLinks=NULL){
    
    $url_information = parse_url($link);
    
    $crawl = new Crawler($link);

    $links = $crawl->get('links');
    $main_host = $url_information['host'];
    echo 'main-host:'.$main_host."\n";
    foreach($links AS $link){
            
            unset($host);
            unset($match_host);
            $href = '';
            $title = '';
            preg_match('/href=["\']?([^"\'>]+)["\']?/', '<a'.$link.'>', $urlmatch);
            if(isset($urlmatch[1])){
                $href = $urlmatch[1];
                if(!is_absolute_path($href)){
                    $href = rel2abs($href, $main_host);
                }
                $match_host = getURLHost($href);
                
                //echo $href.'-'.$match_host.'-'."\n";
                if(!is_absolute_path($href)){
                    $href = rel2abs($href, $main_host);
                }
                if(empty($match_host))
                    $host = $main_host;
                else{
                    $host = $match_host;
                }
                if($host == $main_host)
                    $add = TRUE;
                else
                    $add = FALSE;
                
                
                preg_match('/title=["\']?([^"\'>]+)["\']?/', '<a'.$link.'>', $titlematch);
                if(isset($titlematch[1]))
                    $title = $titlematch[1];

                
                if((isset($match_host))&&($match_host == $main_host)&&(!empty($href))){
                    if($add&&is_absolute_path($href)){
                        $returnlinks[] = $href;
                        $titles[] = $title;
                    }
                    //$pushArray = $crawl::crawlWebsiteLinks($href, array('links'=>$returnlinks, 'titles'=>$titles));
                }
            }
            
            
            
    }
    
    return array('links'=>$returnlinks, 'titles'=>$titles);

}

    function spider($url, $all_links=NULL, $maxRounds=5000, $i=0){
        $first_site = Crawler::crawlWebsiteLinks($url);
        $first_site_links = $first_site['links'];
        if(!empty($all_links)){
            $all_links = $first_site_links;
        }
        echo $i;
        foreach($first_site_links AS $first_site_link){
            $new_site[$i] = Crawler::crawlWebsiteLinks($first_site_link);
            echo $new_site_link."\n";
            foreach($new_site[$i]['links'] AS $new_site_link){
                if(!in_array($new_site_link, $all_links)){
                    $all_links[] = $new_site_link;
                    array_merge($new_site_link, $all_links, $maxRounds, $i);

                }
                echo $i.-'      '.$new_site_link."\n";
                $i++;
            }


            $i++;
                if($i>$maxRounds)
                    return $all_links;
        }
        return $all_links;
    }

    function getMeta($html){

        //parsing begins here:
        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $nodes = $doc->getElementsByTagName('title');

        //get and display what you need:
        $title = $nodes->item(0)->nodeValue;

        $metas = $doc->getElementsByTagName('meta');

        for ($i = 0; $i < $metas->length; $i++)
        {
            $meta = $metas->item($i);
            if($meta->getAttribute('name') == 'description')
                $description = $meta->getAttribute('content');
            else 
                $description = '';
            
            if($meta->getAttribute('name') == 'keywords')
                $keywords = $meta->getAttribute('content');
        }
        return array('title'=>$title, 'description'=>$description, 'keywords'=>$keywords);
    }


    function createContentFromURL($url){
        $curlArray = curler($url);
        
        $status = $curlArray['status'];
        $html = $curlArray['html'];
        if($status == 200){
            $basepath = getBasePathFromUrl($url);
            $pageInfo = $this->getMeta($html);
            
            
            $html = preg_replace('/< *script[^>]*src *= *["\']?([^"\']*)/s', '<script src="http://'.$basepath.'/'."$1",$html);
            //var_dump($requiredFiles);
            
            $html = preg_replace('/< *link[^>]*href *= *["\']?([^"\']*)/i', '<link href="http://'.$basepath.'/'."$1",$html);
            var_dump($html);
            
            //echo 'asd';
            
            $content = new content();
            
            
            $content->create(1, $pageInfo['title'], $pageInfo['keywords'], $pageInfo['description'], base64_encode($html), -1, true, null);
            
        }else{
            echo 'error 404';
        }

    }
}
$crawler = new Crawler('http://www.google.com');
echo($crawler->createContentFromURL('http://transparency-everywhere.com'));



