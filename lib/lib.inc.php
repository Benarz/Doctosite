<?php
/**
 * Library file
 * ------------
 * 
 * Date : 07/06/2016
 * Authors : 
 *      A. PREST
 *      T. COSCUJUELA
 */

/**
 * Function List :
 * ---------------
 * sendError -> Generate 40X error and exit
 * createConnect -> 
 *
 *
 *
 */

function sendError($errorCode){
    /**
     * Sets the header, adds error page content, exits
     * @errorCode integer (403, 404, ...)
     */

    $errorCodes = Array(
        403 => "403 Forbidden",
        404 => "404 Not Found",
    );
    
    header("HTTP/1.1 $errorCodes[$errorCode]");
    include "errors/$errorCode.php";
    exit;

    return;
}

function dbConnect(){
    /**
     * Uses values from config.inc.php to connect to the database
     */

    $success = True;
    return $success;
}

function dbDisconnect(){
    /**
     * Lose connection to the database
     */
    mysql_close();
    return True;
}

function genSalt(){
	/**
	* Generate 64 char 
	*/
 $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
         $i = 0;
		$salt = "";
        while ($i < 64) {
            $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
            $i++;
        }
    return $salt;
}

?>
