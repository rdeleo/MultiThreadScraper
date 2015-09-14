<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 01/09/15
 * Time: 15:52
 */

namespace RDeLeo\MultiThreadScraper\Libraries;


class SimpleCSVWriterLibrary extends FileHelper
{

    protected $csvFileName;
    protected $csvFilePath;
    protected $arrayToCsv = Array();

    /**
     * @param string $csvFileName
     * @param string $csvFilePath
     */
    public function __construct($csvFilePath, $csvFileName)
    {
        $this->csvFileName = (string)$csvFileName;
        $this->csvFilePath = (string)$csvFilePath;
    }

    /**
     * @param $arrayToCsv
     * @return bool
     * @throws \Exception
     */
    public function writeCSV($arrayToCsv)
    {
        try {
            $this->arrayToCsv  = $arrayToCsv;

            $this->isWritableCheck($this->csvFilePath);

            $file = fopen($this->csvFilePath.$this->csvFileName,"w");

            foreach ($this->arrayToCsv as $resultPerThread)
            {
                foreach ($resultPerThread AS $key=>$line)
                {
                    fputcsv($file,Array($key=>$line));
                }
            }

            fclose($file);
            return TRUE;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}