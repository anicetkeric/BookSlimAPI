<?php

/**
 * Created by PhpStorm.
 * User: ANICET ERIC KOUAME
 * Date: 20/01/2017
 * Time: 09:25
 * Copyright 2017 @ 
 *
 * This file is part of CORE API.
 *
 * CORE API is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Database Connect
 */
require_once("Constants.php");
class Manager{
    
    function __construct() {
        try {
                return new PDO(TYPE_CNX.':host='.DB_HOST.';dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
            }
        catch (PDOException $e) {
            return FALSE;
        }
     }

}

?>
