<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 11/09/15
 * Time: 13:57
 */

namespace RDeLeo\MultiThreadScraper\Libraries;

trait TestHelperTrait
{
    protected $startTime;

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    protected function startTest($method)
    {
        $this->startTime = round(microtime(true) * 1000);
        $result =  "...............................................................................\n";
        $start = microtime(true);
        $microStart = sprintf("%06d",($start - floor($start)) * 1000000);
        $result .= ".. Test Method : ".$method."\n";
        $result .= ".. Start Time  : ".date('Y-m-d H:i:s.'.$microStart, $start)." (UTC)\n";
        return $result;
    }
    protected function endTest()
    {
        $end = microtime(true);
        $milliEnd = round(microtime(true) * 1000);
        $microEnd = sprintf("%06d",($end - floor($end)) * 1000000);
        $executionTime = $milliEnd - $this->startTime;
        $result  = ".. Exec Time   : ".$executionTime." ms\n";
        $result .= ".. End  Time   : ".date('Y-m-d H:i:s.'.$microEnd, $end)." (UTC)\n";
        $result .=  "................................................................................\n";
        return $result;
    }


}