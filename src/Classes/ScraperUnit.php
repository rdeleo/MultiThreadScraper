<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 01/09/15
 * Time: 15:34
 */

namespace RDeLeo\MultiThreadScraper\Classes;

use RDeLeo\MultiThreadScraper\Libraries\JacobWardScraperLibrary;

class ScraperUnit {

    protected   $scraperLibrary;
    public      $rinkworksName = Array();

    public function __construct(JacobWardScraperLibrary $scraperLibrary)
    {
        $this->scraperLibrary = $scraperLibrary;
    }

    protected function cleanHtmlScrapedFromRinkworks($html)
    {
        $start  = "<table class='fnames_results'>";
        $stop   = "</table>";
        $first  = $this->scraperLibrary->scrapeBetween($html, $start, $stop);
        $second = str_ireplace(array("\r","\n","'",'\r','\n'),'', $first);
        $third  = str_ireplace("<tr>", "", $second);
        $fourth = str_ireplace("</tr>", "", $third);
        $fifth  = explode("<td>", $fourth);
        foreach ($fifth AS $dirtyName)
        {
            if(!empty($dirtyName)) $this->rinkworksName[] = trim(str_ireplace("</td>", "", $dirtyName));
        }
    }

    public function __invoke($urls)
    {
        foreach($urls AS $url)
        {
            $result = $this->scraperLibrary->curlGet($url);
            $this->cleanHtmlScrapedFromRinkworks($result['data']);
        }
        return $this->rinkworksName;
    }

}