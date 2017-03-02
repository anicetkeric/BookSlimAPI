<?php

//including the required files
require_once '../Manager/DataManager.php';
require_once '../Data/Data.php';
require '.././libs/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

/* *
 * URL: http://localhost/BookSlimAPI/output/bookinsert
 * Parameters: title, author, price
 * Method: POST
 * */
$app->post('/bookinsert', function () use ($app) {
    verifyRequiredParams(array('title', 'author', 'price'));
    $response = array();
    $book=new Data();
    $book->setTitle($app->request->post('title'));
    $book->setAuthor($app->request->post('author'));
    $book->setPrice($app->request->post('price'));

    $db = new DataManager();
    $res = $db->insertBook($book);

    if ($res > 0) {
        $response["error"] = false;
        $response["message"] = "book added";
        echoResponse(201, $response);
    } else{
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while registereing";
        echoResponse(200, $response);
    }
});


/* *
 * URL: http://localhost/BookSlimAPI/output/bookupdate
 * Parameters: id, title, author, price
 * Method: POST
 * */
$app->post('/bookupdate', function () use ($app) {
    verifyRequiredParams(array('id','title', 'author', 'price'));
    $response = array();
    $book=new Data();
    $book->setId($app->request->post('id'));
    $book->setTitle($app->request->post('title'));
    $book->setAuthor($app->request->post('author'));
    $book->setPrice($app->request->post('price'));

    $db = new DataManager();
    $res = $db->updateBook($book);

    $response['books'] = array();

    if ($res) {
        $response["error"] = false;
        $response["message"] = "book updated";
        array_push($response['books'],$res);
        echoResponse(201, $response);
    } else{
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while update";
        echoResponse(200, $response);
    }
});


/* *
 * URL: http://localhost/BookSlimAPI/output/bookdelete
 * Parameters: id
 * Method: POST
 * */
$app->post('/bookdelete', function () use ($app) {
    verifyRequiredParams(array('id'));
    $response = array();

    $db = new DataManager();
    $res = $db->deleteBook($app->request->post('id'));


    if ($res>0) {
        $response["error"] = false;
        $response["message"] = "book deleted";
        echoResponse(201, $response);
    } else{
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while delete";
        echoResponse(200, $response);
    }
});

/* *
 * URL: http://localhost/BookSlimAPI/output/book
 * Parameters: none
 * Authorization: Put API Key in Request Header
 * Method: GET
 * */
$app->get('/book', function() use ($app){
    $db = new DataManager();
    $result = $db->GetAllbook();

    $response = array();
    $response['error'] = false;
    $response['books'] = array();


    if($result){
        $response['message'] = "success";
        array_push($response['books'],$result);
    }else{
        $response['error'] = true;
        $response['message'] = "Could not submit assignment";
    }

    echoResponse(200,$response);
});


/* *
 * URL: http://localhost/BookSlimAPI/output/book/<book_id>
 * Parameters: none
 * Method: GET
 * */
$app->get('/book/:id', function($bookid) use ($app){
    $db = new DataManager();
    $result = $db->Getbook($bookid);

    $response = array();
    $response['error'] = false;
    $response['books'] = array();


    if($result){
        $response['message'] = "success";
        array_push($response['books'],$result);
    }else{
        $response['error'] = true;
        $response['message'] = "Could not submit assignment";
    }

    echoResponse(200,$response);
});

function echoResponse($status_code, $response)
{
    $app = \Slim\Slim::getInstance();
    $app->status($status_code);
    $app->contentType('application/json');
    echo json_encode($response);
}


function verifyRequiredParams($required_fields)
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


$app->run();