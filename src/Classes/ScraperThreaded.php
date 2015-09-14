<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 01/09/15
 * Time: 15:35
 */

namespace RDeLeo\MultiThreadScraper\Classes;

class ScraperThreaded extends \Threaded
{
    protected $url;
    protected $result;

    public function __construct($url) {
        $this->url = $url;
    }

    public function run() {
        $scraper01 = $this->worker->getConnection();
        $this->result = $scraper01($this->url);
    }

    public function getResult() {
        return $this->result;
    }
}