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
 * shared functions
 */
class Common {
    

    public static function echoResponse($status_code, $response)
    {
        $app = \Slim\Slim::getInstance();
        $app->status($status_code);
        $app->contentType('application/json');
        echo json_encode($response);
    }
    
    
    public static function verifyRequiredParams($required_fields)
    {
        $error = false;
        $error_fields = "";
        $request_params = $_REQUEST;
    
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $app = \Slim\Slim::getInstance();
            parse_str($app->request()->getBody(), $request_params);
        }
    
        foreach ($required_fields as $field) {
            if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
                $error = true;
                $error_fields .= $field . ', ';
            }
        }
    
        if ($error) {
            $response = array();
            $app = \Slim\Slim::getInstance();
            $response["error"] = true;
            $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
            echoResponse(400, $response);
            $app->stop();
        }
    }



}

?>
