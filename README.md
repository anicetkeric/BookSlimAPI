# BookSlimAPI
PHP Restful API Slim Framework CRUD


# Overview
Slim is a PHP micro framework that helps you quickly write simple yet powerful web applications and APIs. (https://www.slimframework.com/)

you can Download SLIM Framework from [Here](https://github.com/slimphp/Slim).


# Prerequisites
*	PHP + Mysql (With Mysqlnd extension)
* WAMP / XAMPP Server (I will be using wamp server) 
* PHP IDE
* Postman to test our API: https://www.getpostman.com/apps

# MYSQL
 use book_db database
 
### Create database and tables
```sql
CREATE TABLE IF NOT EXISTS `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(35) NOT NULL,
  `author` varchar(35) NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
```

# Creating REST API

First you need to create a PHP Project. You have to create it in the root directory of your server like it will be htdocs folder in case of xampp and www in case of wamp.

In my case **C:\wamp\www\BookSlimAPI**.

## Project structure

![capture 1](https://github.com/anicetkeric/BookSlimAPI/blob/master/screen/1.PNG)

* Data: class representative our book table
* libs : All the third party libraries goes here. In our case we place Slim library here
* Manager:  database business logic
* index.php : Takes care of all the API requests
* .htaccess : Rules for url structure and other apache rules 


## Testing Our API

| Description        | Method |Route  | Params
| ------------- |:-------------:| -----|-----|
| Creating a new book    | POST |http://localhost/BookSlimAPI/api/book |title, author, price |
|Listing all books      | GET      |  http://localhost/BookSlimAPI/api/books | none
| Listing single book | GET     |   http://localhost/BookSlimAPI/api/book/{book_id} | none
| Deleting a book |DELETE      |   http://localhost/BookSlimAPI/api/book/{book_id} | none
| Updating a book | PUT     |   http://localhost/BookSlimAPI/api/book/{book_id} | id, title, author, price|

in my case i change the apache port as 1180

* http://localhost:1180/BookSlimAPI/api/book

![capture 2](https://github.com/anicetkeric/BookSlimAPI/blob/master/screen/2.PNG)


* http://localhost:1180/BookSlimAPI/api/book/{book_id}

![capture 3](https://github.com/anicetkeric/BookSlimAPI/blob/master/screen/3.PNG)


* http://localhost:1180/BookSlimAPI/api/book

![capture 4](https://github.com/anicetkeric/BookSlimAPI/blob/master/screen/4.PNG)



* http://localhost:1180/BookSlimAPI/api/book/14

![capture 5](https://github.com/anicetkeric/BookSlimAPI/blob/master/screen/5.PNG)
