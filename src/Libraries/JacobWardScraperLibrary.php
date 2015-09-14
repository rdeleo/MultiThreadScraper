<?php
/**
 * Created by PhpStorm.
 * User: rdeleo
 * Date: 31/08/15
 * Time: 20:25
 *
 * Fork from article http://www.jacobward.co.uk/working-with-the-scraped-data-part-2/
 *
 */

namespace RDeLeo\MultiThreadScraper\Libraries;

class JacobWardScraperLibrary {

    /**
     * @param   string      $url
     * @return  array
     * @throws  \Exception
     */
    public function curlGet($url)
    {
        // Assigning cURL options to an array
        $options = Array(
            CURLOPT_RETURNTRANSFER  => TRUE,        // Setting cURL's option to return the webpage data
            CURLOPT_FOLLOWLOCATION  => TRUE,        // Setting cURL to follow 'location' HTTP headers
            CURLOPT_AUTOREFERER     => TRUE,        // Automatically set the referer where following 'location' HTTP headers
            CURLOPT_CONNECTTIMEOUT  => 120,         // Setting the amount of time (in seconds) before the request times out
            CURLOPT_TIMEOUT         => 120,         // Setting the maximum amount of time for cURL to execute queries
            CURLOPT_MAXREDIRS       => 10,          // Setting the maximum number of redirections to follow
            CURLOPT_USERAGENT       => "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8",  // Setting the useragent
            CURLOPT_URL             => $url,        // Setting cURL's URL option with the $url variable passed into the function
        );

        /**
         * rdeleo : added error management
         */
        try {
            $ch = curl_init();                          // Initialising cURL
            curl_setopt_array($ch, $options);           // Setting cURL's options using the previously assigned array data in $options
            $data = curl_exec($ch);                     // Executing the cURL request and assigning the returned data to the $data variable

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if($data === FALSE) throw new \ErrorException("CURL Error : ".curl_error($ch), curl_errno($ch));

            curl_close($ch);                            // Closing cURL
            return Array(
                'httpCode'      => $httpCode,
                'httpMessage'   => $this->httpCodeMessage($httpCode),
                'data'          => $data
            );

        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param   string  $data
     * @param   string  $start
     * @param   string  $end
     * @return  string
     * @throws  \Exception
     */
    public function scrapeBetween($data, $start, $end)
    {
        try {
            $data = stristr($data, $start);             // Stripping all data from before $start
            $data = substr($data, strlen($start));      // Stripping $start
            $stop = stripos($data, $end);               // Getting the position of the $end of the data to scrape
            $data = substr($data, 0, $stop);            // Stripping all data from after and including the $end of the data to scrape
            return $data;                               // Returning the scraped data from the function
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param   $http_code
     * @return  mixed
     * @throws  \Exception
     */
    protected function httpCodeMessage($http_code)
    {
        $http_codes = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => 'Switch Proxy',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            418 => 'I\'m a teapot',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            425 => 'Unordered Collection',
            426 => 'Upgrade Required',
            449 => 'Retry With',
            450 => 'Blocked by Windows Parental Controls',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            509 => 'Bandwidth Limit Exceeded',
            510 => 'Not Extended'
        );
        if (!isset($http_codes[$http_code])) throw new \Exception("Invalid http code : << ".$http_code." >>");
        else return $http_codes[$http_code];
    }

}