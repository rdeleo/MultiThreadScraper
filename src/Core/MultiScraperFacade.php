<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 01/09/15
 * Time: 15:06
 */

namespace RDeLeo\MultiThreadScraper\Core;

use RDeLeo\MultiThreadScraper\Classes\ScraperThreaded;
use RDeLeo\MultiThreadScraper\Libraries\SimpleCSVWriterLibrary;

class MultiScraperFacade {

    public  $results = Array();
    private $pool;
    private $threadNumber;
    private $urlsArray;
    private $urlsPerThread;
    private $csvObj;

    /**
     * @param $threadNumber     : It must be the same or less than the maximum thread of the system.
     * @param $urlsArray        : map( int | string )
     * @param $csvFileName      : csv destination file name
     * @param $csvFilePath      : csv destination file path
     * @throws \Exception
     */
    public function __construct($threadNumber, $urlsArray, $csvFileName, $csvFilePath)
    {
        try {
            /**
             * I prefer to use exception to manage errors, so this closure edit standard_error_handler to excpetion
             */
            set_error_handler(function ($err_severity, $err_msg, $err_file, $err_line, array $err_context) {
                // error was suppressed with the @-operator
                if (0 === error_reporting()) {
                    return false;
                }
                throw new \ErrorException($err_msg, 0, $err_severity, $err_file, $err_line);
            });

            $this->csvObj = new SimpleCSVWriterLibrary($csvFilePath, $csvFileName);

            if(!is_int($threadNumber)) throw new \Exception("Thread Number must be an integer number.");
            $this->threadNumber = $threadNumber;

            if(!is_array($urlsArray)) throw new \Exception("Urls Array must be an array.");
            $this->urlsArray = $urlsArray;

            $this->processUrls();

            $this->pool = new \Pool($this->threadNumber, "RDeLeo\\MultiThreadScraper\\Classes\\ScraperFactoryWorker");
        } catch (\Exception $e) {
            throw $e;
        }

    }

    /**
     * @throws \Exception
     */
    public function execute()
    {
        try {

            foreach ($this->urlsPerThread AS $urlsPerThread)
            {
                $this->pool->submit(new ScraperThreaded($urlsPerThread));
            }
            $this->pool->shutdown();
            /* ::collect is used here for shorthand to dump query results */
            $this->pool->collect(function($go){
                $this->results[] = $go->getResult();
            });

            $this->csvObj->writeCSV($this->results);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function processUrls()
    {
        $count                  = count($this->urlsArray);
        $urlsPerThread          = $count / $this->threadNumber;
        $roundedUrlsPerThread   = $this->roundUp($urlsPerThread);

        $threadNumberCheck = $count / $roundedUrlsPerThread;


        if ($threadNumberCheck != $this->threadNumber) $this->threadNumber = $threadNumberCheck;

        $this->urlsPerThread    = array_chunk($this->urlsArray, $roundedUrlsPerThread);
    }

    /**
     * @param $value
     * @param int $places
     * @return float
     * @throws \Exception
     */
    private static function roundUp($value, $places = 0)
    {
        try {
            $multiple = pow(10, abs($places));
            return $places < 0 ? ceil($value / $multiple) * $multiple : ceil($value * $multiple) / $multiple;
        } catch (\Exception $e) {
            throw $e;
        }
    }

}