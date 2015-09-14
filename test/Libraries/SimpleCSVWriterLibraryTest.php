<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 11/09/15
 * Time: 13:59
 */

use RDeLeo\MultiThreadScraper\Libraries\TestHelperTrait;
use RDeLeo\MultiThreadScraper\Libraries\SimpleCSVWriterLibrary;

class SimpleCSVWriterLibraryTest extends PHPUnit_Framework_TestCase
{
    use TestHelperTrait;

    protected $simpleCSVWriterLibraryObj;

    public function __construct()
    {
        $this->simpleCSVWriterLibraryObj = new SimpleCSVWriterLibrary("/var/www/html/MultiThreadScraper/assets/", "SimpleCSVWriterLibraryTest.csv");
    }

    public function testWriteCSV()
    {
        echo $this->startTest(__METHOD__);
        $arrayWriteTest = Array(
            1 => Array(
                1 => "This",
                2 => "Is the first",
                3 => "Test"
            ),
            2 => Array(
                1 => "This",
                2 => "Is the second",
                3 => "Test"
            ),
            3 => Array(
                1 => "This",
                2 => "Is the third",
                3 => "Test"
            )
        );
        $this->assertTrue($this->simpleCSVWriterLibraryObj->writeCSV($arrayWriteTest));
        echo $this->endTest();
    }

}
