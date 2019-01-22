# Hexacore

Hexacore is a tiny PHP framework based on MVC pattern. Initially a personal project to improve my PHP with design patterns and the new features from php 7.0+

I think this project can be useful for person wishing to learn PHP and have a better understanding of MVC pattern.

## Installation
### Docker
For a easier deployment you can use docker and docker-compose :
- Docker for [Linux](https://docs.docker.com/install/) or [Windows](https://docs.docker.com/docker-for-windows/)
- Docker-compose [here](https://docs.docker.com/compose/install/)

After the installation of both docker and docker-compose, you just need to execute the following command at the root of the project 
```shell
$ docker-compose up
```

The website should then be running on [http://localhost](http://localhost).

### Wamp installation 
You can also use this framework with a WAMP/LAMP/XAMP

### MYSQL configuration
After creating a database with MYSQL you can link it to the framework with the conficutation file located in App/config/database.json
```json
{
    "dbname": "myDB",
    "host": "db",
    "port": 3306,
    "user": "hexacore",
    "password": "test"
}
```

## Workflow
As I said earlier Hexacore follow the MVC pattern it means that the application is divided in 3 parts :
- Model : representation of the data from the database within hexacore
- View : the HTML/CSS/JS code that make hexacore websites beautiful
- Controller : that orchestrate all the application logic

### Controller
The first thing to do in order to display the homepage is to create a `indexController`.

This is the simplest way to do that :
```php
<?php
namespace App\Controller;

use Hexacore\Core\Controller;
use Hexacore\Core\Response\ResponseInterface;
use Hexacore\Core\Response\Response;

class IndexController extends Controller
{
 public function index(): ResponseInterface
 {
     return new Response("Hello world !");
 }
}
``` 

A controller have to extends from the `Controller` class !!

By default indexController and index action (the function) are not needed in the URL. The home page can then be reach by both [http://localhost](http://locahost) and [http://localhost/index/index](http://locahost/index/index).
Therefore the string after the first / in the url refer to the controller and the other string the action.

#### Adding GET parameters
The frame work allow you to insert get variable in the url avec the controller and action as shown here :
```
http://localhost/user/get/athena
```

You can then handle the variable directly as a parameter of your action get of the `UserController` class :
```php
<?php
namespace App\Controller;

use Hexacore\Core\Controller;
use Hexacore\Core\Response\ResponseInterface;
use Hexacore\Core\Response\Response;

class Userontroller extends Controller
{
 public function get(String $name): ResponseInterface
 {
     return new Response("Welcome $name !");
 }
}
```
You can add as many get parameter as you want.

You can also get these variables with the standard way (`http://localhost/user/get?name=athena`) with the request object : 
```php
<?php
namespace App\Controller;

use Hexacore\Core\Controller;
use Hexacore\Core\Response\ResponseInterface;
use Hexacore\Core\Response\Response;

class Userontroller extends Controller
{
 public function get(): ResponseInterface
 {
     //for a post variable submitted
     //$this->request->getPost("var");
     $name = $this->request->getQuery("var");
     return new Response("Welcome $name !");
 }
}
```