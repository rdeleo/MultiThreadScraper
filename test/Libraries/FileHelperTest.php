<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 12/09/15
 * Time: 21:26
 */

use RDeLeo\MultiThreadScraper\Libraries\FileHelper;
use RDeLeo\MultiThreadScraper\Libraries\TestHelperTrait;

class FileHelperTest extends PHPUnit_Framework_TestCase
{
    use TestHelperTrait;

    protected $fileHelperObj;
    protected $reflectionClass;

    public function __construct()
    {
        $this->fileHelperObj = new FileHelper();
        $this->reflectionClass = new \ReflectionClass(get_class($this->fileHelperObj));
    }

    public function testFileExistsCheck()
    {
        echo $this->startTest(__METHOD__);
        $method = $this->reflectionClass->getMethod("fileExistsCheck");
        $method->setAccessible(true);
        $parameters = Array("/var/www/html/MultiThreadScraper/composer.json");
        $result = $method->invokeArgs($this->fileHelperObj, $parameters);
        $this->assertTrue($result);
        try{
            $parameters2 = Array("/var/www/MultiThreadScraper/composer_ERROR_.json");
            $method->invokeArgs($this->fileHelperObj, $parameters2);
        } catch(\Exception $e) {
            $this->assertEquals(1, $e->getCode());
            $this->assertTrue(is_string($e->getMessage()));
            echo ".. ".$e->getCode()." - ".$e->getMessage()."\n";
        }
        echo $this->endTest();
    }

    public function testIsReadableCheck()
    {
        echo $this->startTest(__METHOD__);
        $method = $this->reflectionClass->getMethod("isReadableCheck");
        $method->setAccessible(true);
        $parameters = Array("/var/www/html/MultiThreadScraper/composer.json");
        $result = $method->invokeArgs($this->fileHelperObj, $parameters);
        $this->assertTrue($result);
        try{
            $parameters2 = Array("/var/www/MultiThreadScraper/assets/NOTREADABLE");
            $method->invokeArgs($this->fileHelperObj, $parameters2);
        } catch(\Exception $e) {
            $this->assertEquals(2, $e->getCode());
            $this->assertTrue(is_string($e->getMessage()));
            echo ".. ".$e->getCode()." - ".$e->getMessage()."\n";
        }
        echo $this->endTest();
    }

    public function testIsWritableCheck()
    {
        echo $this->startTest(__METHOD__);
        $method = $this->reflectionClass->getMethod("isWritableCheck");
        $method->setAccessible(true);
        $parameters = Array("/var/www/html/MultiThreadScraper/composer.json");
        $result = $method->invokeArgs($this->fileHelperObj, $parameters);
        $this->assertTrue($result);
        try{
            $parameters2 = Array("/var/www/MultiThreadScraper/assets/NOTREADABLE");
            $method->invokeArgs($this->fileHelperObj, $parameters2);
        } catch(\Exception $e) {
            $this->assertEquals(3, $e->getCode());
            $this->assertTrue(is_string($e->getMessage()));
            echo ".. ".$e->getCode()." - ".$e->getMessage()."\n";
        }
        echo $this->endTest();
    }

    public function testIsExecutableCheck()
    {
        echo $this->startTest(__METHOD__);
        $method = $this->reflectionClass->getMethod("isExecutableCheck");
        $method->setAccessible(true);
        $parameters = Array("/var/www/html/MultiThreadScraper/assets/EXECUTABLE");
        $result = $method->invokeArgs($this->fileHelperObj, $parameters);
        $this->assertTrue($result);
        try{
            $parameters2 = Array("/var/www/MultiThreadScraper/assets/NOTREADABLE");
            $method->invokeArgs($this->fileHelperObj, $parameters2);
        } catch(\Exception $e) {
            $this->assertEquals(4, $e->getCode());
            $this->assertTrue(is_string($e->getMessage()));
            echo ".. ".$e->getCode()." - ".$e->getMessage()."\n";
        }
        echo $this->endTest();
    }

}