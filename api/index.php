<?php

//including the required files
require_once '../Manager/DataManager.php';
require_once '../Data/Data.php';
require '.././libs/Slim/Slim.php';
require_once '../shared/Common.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

/* *
 * URL: http://localhost/BookSlimAPI/api/book
 * Parameters: JSON (title, author, price)
 * Method: POST
 * */
$app->post('/book', function () use ($app) {
    $data = json_decode($app->request->getBody());
    $response = array();
    $book = new Data();
    $book->setTitle($data->title);
    $book->setAuthor($data->author);
    $book->setPrice($data->price);

    $db = new DataManager();
    $res = $db->insertBook($book);

    if ($res > 0) {
        $response["is_success"] = true;
        $response["message"] = "book added";
        Common::echoResponse(201, $response);
    } else{
        $response["is_success"] = false;
        $response["message"] = "Oops! An error occurred while registereing";
        Common::echoResponse(400, $response);
    }
});


/* *
 * URL: http://localhost/BookSlimAPI/api/book/<book_id>
 * Parameters: JSON (title, author, price)
 * Method: PUT
 * */
$app->put('/book/:id', function($bookid) use ($app){

    $data = json_decode($app->request->getBody());
    $response = array();
    $book=new Data();
    $book->setId($bookid);
    $book->setTitle($data->title);
    $book->setAuthor($data->author);
    $book->setPrice($data->price);

    $db = new DataManager();
    $res = $db->updateBook($book);

    $response['data'] = array();

    if ($res) {
        $response["is_success"] = true;
        $response["message"] = "book updated";
        $response['data'] = $res;
        Common::echoResponse(201, $response);
    } else{
        $response["is_success"] = false;
        $response["message"] = "Oops! An error occurred while update";
        Common::echoResponse(200, $response);
    }
});


/* *
 * URL: http://localhost/BookSlimAPI/api/book/<book_id>
 * Parameters: none
 * Method: DELETE
 * */
$app->delete('/book/:id', function($bookid) use ($app){

    $response = array();

    $db = new DataManager();


    if($db->Getbook($bookid)){
        $res = $db->deleteBook($bookid);
        if ($res > 0) {
            $response["is_success"] = true;
            $response["message"] = "book deleted";
            Common::echoResponse(200, $response);
        } else{
            $response["is_success"] = false;
            $response["message"] = "Oops! An error occurred while delete";
            Common::echoResponse(400, $response);
        }
    }else{
        $response["is_success"] = false;
        $response['message'] = "No data found";
        Common::echoResponse(404, $response);
    }




});

/* *
 * URL: http://localhost/BookSlimAPI/api/books
 * Parameters: none
 * Method: GET
 * */
$app->get('/books', function() use ($app){
    $db = new DataManager();
    $result = $db->GetAllbook();

    $response = array();
    $response['is_success'] = true;
    $response['data'] = null;

    if($result){
        $response['message'] = "success";
        $response['data'] = $result;
    }else{
        $response['is_success'] = false;
        $response['message'] = "Unable to get data";
    }
  
    Common::echoResponse(200,$response);
});


/* *
 * URL: http://localhost/BookSlimAPI/api/book/<book_id>
 * Parameters: none
 * Method: GET
 * */
$app->get('/book/:id', function($bookid) use ($app){
    $db = new DataManager();
    $result = $db->Getbook($bookid);

    $response = array();
    $response['is_success'] = true;
    $response['data'] = null;


    if($result){
        $response['message'] = "success";
        $response['data'] = $result;
    }else{
        $response['is_success'] = false;
        $response['message'] = "No data found";
    }

    Common::echoResponse(200,$response);
});




$app->run();