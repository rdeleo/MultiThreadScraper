<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 31/08/15
 * Time: 20:24
 */

namespace RDeLeo\MultiThreadScraper\Classes;

use RDeLeo\MultiThreadScraper\Libraries\JacobWardScraperLibrary;

include_once "/var/www/html/MultiThreadScraper/src/Classes/ScraperUnit.php";
include_once "/var/www/html/MultiThreadScraper/src/Libraries/JacobWardScraperLibrary.php";


class ScraperFactoryWorker extends \Worker
{
    /**
     * Note that the link is stored statically, which for pthreads, means thread local
     **/
    protected static $scraperUnit;
    protected static $scraperLibrary;
    /**
     * @return ScraperUnit
     */
    public function getConnection()
    {
        if (!self::$scraperLibrary) {
            self::$scraperLibrary = new JacobWardScraperLibrary();
        }

        if (!self::$scraperUnit) {
            self::$scraperUnit = new ScraperUnit(self::$scraperLibrary);
        }
        return self::$scraperUnit;
    }
}