<?php
/**********************
 * 
 * Utility functions
 * 
 * @file utils.php
 * @brief Provides a set of general functions
 **********************/

if (!function_exists('loadJS')) {
    /**
     * load JavaScript into DOM
     * @param  string $src URL of JavaScript file
     */
    function loadJS($src)
    {
        echo '<script type="text/javascript" src="'.$src.'"></script>';
    }
}

if (!function_exists('writeScript')) {
    /**
     * Write embeded JavaScript into DOM
     * @param  string $script JS code
     */
    function writeScript($script)
    {
        echo '<script type="text/javascript">';
        echo $script;
        echo '</script>';
    }
}

/*
 add class to attribute string
 */
if (!function_exists('addClass')) {
    /**
     * add class for a tag, to be used before rendering a tag into DOM
     * @param string $newclass new class 
     * @param string $attr     original tag string
     */
    function addClass($newclass, $attr)
    {
        $pos = strpos($attr, 'class="');
        if ($pos === false) {
            $offset = 0;
            $newclass = 'class="'.$newclass.'"';
        } else {
            $offset = $pos+7;
        }
        $part1 = substr($attr, 0, $offset);
        $part2 = substr($attr, $offset);
         
        $part1 = $part1 . $newclass.' ';
        $whole = $part1 . $part2;
        return $whole;
    }
}

if (!function_exists('starts_with')) {
    /**
     * check if a string starts with $prefix
     * @param  string $string The target string
     * @param  string $prefix string to be checked if the target string has as a start-with
     * @return boolean        True if $prefix is the beginning of $string
     */
    function starts_with($string, $prefix)
    {
        return strpos($string, $prefix) === 0;
    }
}


if (!function_exists('twoDecimal')) {
    /**
     * Convert a number to 2 decimal places
     * @param  float $number the number to be converted.
     */
    function twoDecimal($number)
    {
        return number_format((float)$number, 2);
    }
}

if (!function_exists('cleanArray')) {
    /**
     * Clean up the values in an array
     * @param  array $array array with values to be cleaned (ie. $_POST, $_GET)
     * @return array             array with cleaned values
     */
    function cleanArray($array)
    {
        foreach ($array as $key => $value) {
            $array[$key] = urldecode(trim($value));
        }
        return $array;
    }
}


/**
 @param $msg

 @param $url
 

 */
if (!function_exists('js_redirect')) {
    /**
     *  redirect to another page using javascript
     * @param  string  $msg      message to display when redirecting
     * @param  string  $url      url to redirect to
     * @param  integer $timeout  timeout in ms before redirect happens (default to 2000)
     */
    function js_redirect($msg, $url, $timeout=2000)
    {
        echo $msg.'<br />';
        echo 'If your browser did not redirect automatically, please <a href="'.$url.'">click here</a>';
        echo '<script type="text/javascript">setTimeout(function(){window.location = "'.$url.'";},'.$timeout.');</script>';
    }
}


if (!function_exists('validEmail')) {
    /**
     * check if an email is in valid format
     * @param  string $email email to be checked
     * @return boolean        if email is valid
     */
    function validEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}

if (!function_exists('postvar')) {
    /**
     *  short writing to get data in $_POST array
     * @param  string $var variable name ($_POST key)
     * @return mix      value of post var or null
     */
    function postvar($var)
    {
        return (isset($_POST[$var])) ? $_POST[$var] : null;
    }
}


if (!function_exists('generateKey')) {
    /**
     * generates a random n-digit string with alpha-numeric values
     * @param  integer $n length of random string
     * @return string          random string
     */
    function generateKey($n = 10)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $n);
    }
}

if (!function_exists('debugVar')) {
    /**
     * Print value of a variable in <pre> tag
     * @param  mix $var variable to be printed
     */
    function debugVar($var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}

if (!function_exists('sendEmail')) {
    /**
     * Simple wrapper for mail function
     */
    function sendEmail($recipient, $recipient_name, $from, $from_name, $subject, $message)
    {
        $headers = 'From: '.$from_name.' <'.$from.'>' . "\n";
        $headers .= 'MIME-Version: 1.0'. "\n";
        $headers .= "Content-Type: text/html; charset=iso-8859-1 \n";
        return mail($recipient_name.' <'.$recipient.'>', $subject, $message, $headers);
    }
}

if (!function_exists('getDaysInWeek')) {

    /**
     * generate an array of days in a week.
     */
    function getDaysInWeek()
    {
        return array(
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
                'Sunday'
        );
    }
}

if (!function_exists('getCurrentURL')) {
    /**
     * get current url
     * @param  boolean $show_port     include port number
     * @param  boolean $remove_params remove get parameters
     * @return string                 current url
     */
    function getCurrentURL($show_port=false, $remove_params=false)
    {
        $url  = @($_SERVER["HTTPS"] != 'on') ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
        if ($show_port) {
            $url .= ($_SERVER["SERVER_PORT"] !== 80) ? ":".$_SERVER["SERVER_PORT"] : "";
        }
        $url .= $_SERVER["REQUEST_URI"];
        if ($remove_params) {
            list($file, $parameters) = explode('?', $url);
            $url = $file;
        }
        return $url;
    }
}


if (!function_exists('shortenString')) {
    /**
     * shorten a string
     * @param  string  $string original string
     * @param  integer $length targeted number of charactors
     * @return string          shortened string
     */
    function shortenString($string, $length=40)
    {
        if (strlen($string) > $length) {
            return substr($string, 0, $length).'...';
        } else {
            return $string;
        }
    }
}


if (!function_exists('getRESTResult')) {
    /**
     * function to retrieve REST request result
     * @param  string $service_url URL of service endpoint (include parameters if sending a GET request)
     * @param  array  $post_data   (optional) array of data to be passed in a POST request
     * @return string              response from web service.
     */
    function getRESTResult($service_url, $post_data = array())
    {
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if (!empty($post_data)) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        }
        $curl_response = curl_exec($curl);
        curl_close($curl);
        return $curl_response;
    }
}

if (!function_exists('is_image_type')) {
    /**
     * check if a type(string) is image type
     * @param  string  $type   MIME type string
     * @param  boolean $strict set to true if checking specifically one type of image.
     * @return boolean         if MIME type is image
     */
    function is_image_type($type, $strict=true)
    {
        if ($strict) {
            $allowed = array(
                    'image/gif',
                    'image/jpeg',
                    'image/pjpeg',
                    'image/png',
                    'image/svg+xml',
                    'image/bmp',
            );
            return in_array($type, $allowed);
        } else {
            return strstr($type, 'image') != -1;
        }
    }
}


if (!function_exists('add_url_param')) {
    /**
     * Add GET parameter to url
     * @param array $param_array parameters array to be added to url
     */
    function add_url_param($param_array)
    {
        $params = $_GET;
        foreach ($param_array as $key=>$value) {
            unset($params[$key]);
            $params[$key] = $value;
        }
        $new_query_string = http_build_query($params);

        $url = getCurrentURL();
        $pos = strpos($url, '?');
        $url = substr($url, 0, $pos);

        return $url.'?'.$new_query_string;
    }
}

if(!function_exists('add_days_to_ts')){
    /**
     * add X days to a timestamp
     * @param integer $days number of days to add
     * @param integer $ts   original timestamp
     * @return integer      result timestamp
     */
    function add_days_to_ts($days, $ts)
    {
        $sign = '';
        if($days > 0){
            $sign = '+';
        }
        
        return strtotime($sign.$days.' days', $ts);
    }
}


if(!function_exists('days_between_timestamps')) {
    /**
     * get days difference between 2 timestamps
     * @param  integer $ts1 timestamp to compare
     * @param  integer $ts2 timestamp to compare
     * @return integer      days between $ts1 and $ts2
     */
    function days_between_timestamps($ts1, $ts2)
    {
        $days = ceil(($ts1 - $ts2)/60/60/24) ;

        //format -0 to 0
        if ($days < 1 && $days > -1) {
            $days = 0;
        }
        return $days;
    }
}


if(!function_exists('del_by_value')){
    /**
     * delete array element by value
     */
    function del_by_value($array, $del_val)
    {
        return array_values(array_diff($array, array($del_val)));
    }

}

if(!function_exists('turn_on_error_reporting')) {
    /**
     * turn on all error reporting
     */
    function turn_on_error_reporting()
    {
        ini_set('display_startup_errors', 1);
        ini_set('display_errors', 1);
        error_reporting(-1);
    }
}

if(!function_exists('downloadFile')) {
    /**
     * Download file from a $url and store into a $path on server
     */
    function downloadFile($url, $path)
    {
        $newfname = $path;
        $file = fopen($url, "rb");
        if ($file) {
            $newf = fopen($newfname, "wb");

            if ($newf) {
                while (!feof($file)) {
                    fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
                }
            }
        }

        if ($file) {
            fclose($file);
        }

        if ($newf) {
            fclose($newf);
        }
    }
}


if (!function_exists('getDomain')) {
    /**
     * get current domain name wihtout www
     * @return string domain name of current site.
     */
    function getDomain()
    {
        $domain = parse_url(getCurrentURL(), PHP_URL_HOST);
        $domain = str_replace('www.', '', $domain);
        return $domain;
    }
}

if (!function_exists('file_exists_url')) {
    /**
     * check if remote file exists using url
     * @param  string $url  url to file
     * @return boolean      false if not found.
     */
    function file_exists_url($url)
    {
        $file = $url;
        $file_headers = @get_headers($file);
        if ($file_headers[0] == 'HTTP/1.1 404 Not Found') {
            $exists = false;
        } else {
            $exists = true;
        }
    }
}


if(!function_exists('strip_class_namespace')){
    /**
     * remove namespace prefixes of a php class
     * @param  string $long_name full class name with namespace
     * @return stirng            class name only
     */
    function strip_class_namespace($long_name){
        $parts = explode('\\', $long_name);
        return end($parts);
    }
}

if(!function_exists('get_short_class')){
    /**
     * get the class name of an object
     * @param  object $object object to check on
     * @return string         class name of the object without namespaces
     */
    function get_short_class($object){
        $className = get_class($object);
        return strip_class_namespace($className);
    }
}
