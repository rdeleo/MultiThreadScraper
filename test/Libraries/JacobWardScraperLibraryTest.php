<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 12/09/15
 * Time: 22:58
 */

use RDeLeo\MultiThreadScraper\Libraries\TestHelperTrait;
use RDeLeo\MultiThreadScraper\Libraries\JacobWardScraperLibrary;

class JacobWardScraperLibraryTest extends PHPUnit_Framework_TestCase
{

    use TestHelperTrait;

    protected $jacobWardScraperLibrary;

    public function __construct()
    {
        $this->jacobWardScraperLibrary = new JacobWardScraperLibrary();
    }

    public function __destruct()
    {
        unset($this->jacobWardScraperLibrary);
    }

    public function testCurlGet()
    {
        echo $this->startTest(__METHOD__);
        try {
            $result01 = $this->jacobWardScraperLibrary->curlGet("http://www.google.co.uk");
            $this->assertEquals(200, $result01['httpCode']);
            $this->assertTrue(is_string($result01['httpMessage']));
            $this->assertTrue(is_string($result01['data']));

            $this->jacobWardScraperLibrary->curlGet("http://do.not.exist");

        } catch (\Exception $e) {
            $this->assertEquals(6, $e->getCode());
            $this->assertTrue(is_string($e->getMessage()));
            echo ".. ".$e->getCode()." - ".$e->getMessage()."\n";
        }

        try {
            putenv ( "http_proxy=http://false.proxy.lan:8080" );
            $this->jacobWardScraperLibrary->curlGet("http://www.google.co.uk");
            exec ("unset http_proxy");
        } catch (\Exception $e) {
            $this->assertEquals(5, $e->getCode());
            $this->assertTrue(is_string($e->getMessage()));
            echo ".. ".$e->getCode()." - ".$e->getMessage()."\n";
            exec ("unset http_proxy");
        }

        echo $this->endTest();
    }

    public function testScrapeBetween()
    {
        echo $this->startTest(__METHOD__);

        $data   = "<start>THIS IS the test</start>";
        $start  = "<start>";
        $end    = "</start>";

        $result = $this->jacobWardScraperLibrary->scrapeBetween($data, $start, $end);

        $this->assertEquals("THIS IS the test", $result);

        echo $this->endTest();
    }

    public function testHttpCodeMessage()
    {
        echo $this->startTest(__METHOD__);
        try{
            $reflectionClass = new \ReflectionClass(get_class($this->jacobWardScraperLibrary));
            $method = $reflectionClass->getMethod("httpCodeMessage");
            $method->setAccessible(true);
            $parameters = Array("200");
            $result = $method->invokeArgs($this->jacobWardScraperLibrary, $parameters);
            $this->assertEquals("OK", $result);
        } catch (\Exception $e) {
            echo ".. ".$e->getCode()." - ".$e->getMessage()."\n";
        }
        unset($method);
        unset($reflectionClass);
        echo $this->endTest();
    }
}