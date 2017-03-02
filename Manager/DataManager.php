<?php

/**
 * Created by PhpStorm.
 * User: ANICET ERIC KOUAME
 * Date: 20/01/2017
 * Time: 09:47
 *
 * This file is part of CORE API.
 *
 * CORE API is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 *
 */

//require_once  $_SERVER['DOCUMENT_ROOT'].'/BookSlimAPI/Data/Data.php';
require_once("Manager.php");

class DataManager extends Manager
{

    /**
     * @var Manager
     */
    private $_db;

    public function __construct() {

        require_once dirname(__FILE__) . '/../Data/Data.php';

        try{
            $this->_db = parent::__construct();
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }



    public function GetAllbook() {
        $result =  Array();

        $sql = "SELECT * FROM book";
        $requete= $this->_db->prepare($sql);

            $requete->execute();
            $requete->setFetchMode(PDO::FETCH_ASSOC);

            while($ligne = $requete->fetch(PDO::FETCH_ASSOC)) // on r?cup?re la liste
            {
                $result[]=array_map("utf8_encode", $ligne);
            }

            if(count($result)>0) // on r?cup?re la liste
            {
                return $result;

            }else{
                return null;
            }

    }

    public function Getbook($id) {
        $result =  Array();

        $sql = "SELECT * FROM book WHERE `id`=:id";
        $requete= $this->_db->prepare($sql);
        $requete->bindValue(":id", $id);


            $requete->execute();
            $requete->setFetchMode(PDO::FETCH_ASSOC);

            while($ligne = $requete->fetch(PDO::FETCH_ASSOC)) // on r?cup?re la liste
            {
                $result[]=array_map("utf8_encode", $ligne);
            }

            if(count($result)>0) // on r?cup?re la liste
            {
                return $result;

            }else{
                return null;
            }

    }


    public function insertBook(Data $book) {

        $sql = "INSERT INTO `book`(`title`,`author`, `price`) VALUES (:title,:author,:price)";

        $requete= $this->_db->prepare($sql);
        $requete->bindValue(":title", $book->getTitle());
        $requete->bindValue(":author",  $book->getAuthor());
        $requete->bindValue(":price",  $book->getPrice());

            if($requete->execute()){
                return $this->_db->lastInsertId();
            }else{ return   null;}
    }

    public function updateBook(Data $book) {

        $sql = "UPDATE `book` SET `title`=:title,`author`=:author,`price`=:price WHERE id=:id";

        $requete= $this->_db->prepare($sql);
        $requete->bindValue(":id", $book->getId());
        $requete->bindValue(":title", $book->getTitle());
        $requete->bindValue(":author",  $book->getAuthor());
        $requete->bindValue(":price",  $book->getPrice());

            if($requete->execute()){
                return $this->Getbook($book->getId());
            }else{ return null;}
    }

    public function deleteBook($id) {

        $sql = "DELETE FROM `book` WHERE `id`=:id";

        $requete= $this->_db->prepare($sql);
        $requete->bindValue(":id", $id);

            if($requete->execute()){
                return 1;
            }else{ return -1;}
    }




}