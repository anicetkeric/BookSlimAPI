<?php

//including the required files
require_once '../Manager/DataManager.php';
require_once '../Data/Data.php';
require '.././libs/Slim/Slim.php';
require_once '../shared/Common.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

/* *
 * URL: http://localhost/BookSlimAPI/output/bookinsert
 * Parameters: title, author, price
 * Method: POST
 * */
$app->post('/bookinsert', function () use ($app) {
    Common::verifyRequiredParams(array('title', 'author', 'price'));
    $response = array();
    $book = new Data();
    $book->setTitle($app->request->post('title'));
    $book->setAuthor($app->request->post('author'));
    $book->setPrice($app->request->post('price'));

    $db = new DataManager();
    $res = $db->insertBook($book);

    if ($res > 0) {
        $response["error"] = false;
        $response["message"] = "book added";
        Common::echoResponse(201, $response);
    } else{
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while registereing";
        Common::echoResponse(200, $response);
    }
});


/* *
 * URL: http://localhost/BookSlimAPI/output/bookupdate
 * Parameters: id, title, author, price
 * Method: POST
 * */
$app->post('/bookupdate', function () use ($app) {
    Common::verifyRequiredParams(array('id','title', 'author', 'price'));
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
        Common::echoResponse(201, $response);
    } else{
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while update";
        Common::echoResponse(200, $response);
    }
});


/* *
 * URL: http://localhost/BookSlimAPI/output/bookdelete
 * Parameters: id
 * Method: POST
 * */
$app->post('/bookdelete', function () use ($app) {
    Common::verifyRequiredParams(array('id'));
    $response = array();

    $db = new DataManager();
    $res = $db->deleteBook($app->request->post('id'));


    if ($res>0) {
        $response["error"] = false;
        $response["message"] = "book deleted";
        Common::echoResponse(201, $response);
    } else{
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while delete";
        Common::echoResponse(200, $response);
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
  
    Common::echoResponse(200,$response);
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

    Common::echoResponse(200,$response);
});




$app->run();