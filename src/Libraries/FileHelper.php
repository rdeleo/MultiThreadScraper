<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 12/09/15
 * Time: 21:14
 */

namespace RDeLeo\MultiThreadScraper\Libraries;


class FileHelper {

    /**
     * @param $filePathName
     * @return bool
     * @throws \Exception
     */
    protected function fileExistsCheck($filePathName)
    {
        if (!file_exists($filePathName)) throw new \Exception("The file ".$filePathName." does not exist.", 1);
        else return TRUE;
    }

    /**
     * @param $filePathName
     * @return bool
     * @throws \Exception
     */
    protected function isReadableCheck($filePathName)
    {
        if (!is_readable($filePathName)) throw new \Exception($filePathName." is not readable.", 2);
        else return TRUE;
    }

    /**
     * @param $filePathName
     * @return bool
     * @throws \Exception
     */
    protected function isWritableCheck($filePathName)
    {
        if (!is_writable($filePathName)) throw new \Exception($filePathName." is not writable.", 3);
        else return TRUE;
    }

    /**
     * @param $filePathName
     * @return bool
     * @throws \Exception
     */
    protected function isExecutableCheck($filePathName)
    {
        if (!is_executable($filePathName)) throw new \Exception($filePathName." is not executable.", 4);
        else return TRUE;
    }

}