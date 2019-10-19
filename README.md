# Hexacore

[![Lines of Code](https://sonarcloud.io/api/project_badges/measure?project=Zenat0r_hexacore&metric=ncloc)](https://sonarcloud.io/dashboard?id=Zenat0r_hexacore)

Hexacore is a tiny PHP framework based on MVC pattern. Initially a personal project to improve my PHP with design patterns and the new features from php 7.0+

I think this project can be useful for person wishing to learn PHP and have a better understanding of MVC pattern.

[![BCH compliance](https://bettercodehub.com/edge/badge/Zenat0r/hexacore?branch=master)](https://bettercodehub.com/)

[![SonarCloud](https://sonarcloud.io/images/project_badges/sonarcloud-white.svg)](https://sonarcloud.io/dashboard?id=Zenat0r_hexacore)

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=Zenat0r_hexacore&metric=alert_status)](https://sonarcloud.io/dashboard?id=Zenat0r_hexacore)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=Zenat0r_hexacore&metric=security_rating)](https://sonarcloud.io/dashboard?id=Zenat0r_hexacore)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=Zenat0r_hexacore&metric=sqale_rating)](https://sonarcloud.io/dashboard?id=Zenat0r_hexacore)
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

class UserController extends Controller
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

class UserController extends Controller
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
### View
Hexacore use PHP also for templating. The controller has a deticated method to render view from php files.

```php
<?php
namespace App\Controller;

use Hexacore\Core\Controller;
use Hexacore\Core\Response\Response;

class UserController extends Controller
{
    public function index(): Response
    {
        return $this->render("user/index.php");
    }
}
```

This code will render the `index.php` file directly in the `base.php` template file.
You can modify the template file in `App/src/view/base/php`.

As a developer you just need to specify the path of you file (as shown `user/index.php`)
but also where to put it in the `base.php` file.
 
For example:
```html
...
<main>
    <?php echo $block1; ?>
</main>
...
``` 

### Model
You can use Hexacore to persist data. By default it uses mysql database.

You can configure the database name and access in the configuration file
`App/config/database.json`
```json
{
    "dbname": "myHexacoreDb",
    "host": "db",
    "port": 3306,
    "user": "Athena",
    "password": "myDatabasePassword"
}
```

#### Get data
Data from the database can be retrieved in the controller :

```php
<?php
namespace App\Controller;

use Hexacore\Core\Controller;
use Hexacore\Core\Model\Repository\ModelRepository;
use Hexacore\Core\Response\ResponseInterface;
use App\Model\User;

class UserController extends Controller
{
    public function index(ModelRepository $modelRepository): ResponseInterface
    {
        // to get all users
        $allUsers = $modelRepository->setModel(User::class)->findAll();

        // to get the user with the id 1
        $user = $modelRepository->findById(1);
        
        return $this->render("user/index.php", [
            "users" => $allUsers,
            "user" => $user
        ]);
    }
}
```

The `ModelRepository` class will return a Model object, in this example a User Model.

To be able to get all users data you first need to create a model. The model must describe the data you want to
store using private properties. The model is a class that implement `ManageableModelInterface`. This allow Hexacore to interact with
he data base through this model and easily handle it with pre-created object such as `ModelManager`. 

Example :

```php
<?php 

namespace App\Model;

use Hexacore\Core\Model\ManageableModelInterface;

class User implements ManageableModelInterface
{
    
    private $id;
    private $name;
    
   public function getId() : ?int
   {
        return $this->id;
   }
   
   public function setId(int $id) : ManageableModelInterface
   {
        $this->id = $id;
        
        return $this;
   }
} 
``` 

You need to create a corresponding table in your mysql database with the same fields (here `id` and `name`) and table name `User`.

#### Create
We saw earlier that `ModelRepository` could be used to retrieve data from the database. Now to create
and update a Model, we can use ModelManager.

```php
<?php 

namespace App\Controller;

use Hexacore\Core\Controller;
use Hexacore\Core\Model\Manager\ModelManager;
use Hexacore\Core\Response\ResponseInterface;
use Hexacore\Core\Response\Redirect\RedirectionResponse;
use Hexacore\Helpers\Url;
use App\Model\User;

class UserController extends Controller
{
    public function create(ModelManager $modelManager, string $name, Url $url): ResponseInterface
    {
        // create a new user with a personal name
        $user = new User();
        $user->setName($name);

        // actually insert the new user in the database
        $modelManager->persist($user);

        // redirection to another page
        return new RedirectionResponse($url->baseUrl("user"));
    }
}
```

#### Update and Delete
With `ModelManager` you can also delete or update a model.

```php
<?php 

namespace App\Controller;

use Hexacore\Core\Controller;
use Hexacore\Core\Model\Manager\ModelManager;
use Hexacore\Core\Response\ResponseInterface;
use App\Model\User;

class UserController extends Controller
{
    /**
     * For a resource like : user/update/{id}/{name}
     * Example of the query :
     * http://www.yourwebsite.com/user/update/1/zeus
     */
    public function update(ModelManager $modelManager, User $user, string $name): ResponseInterface
    {
        // the $user value will be a User object with data from the user number id
        
        
        // we change the user name
        $user->setName($name);
        
        // we persist this change in the database
        $modelManager->persist($user);

        return new Response("User updated");
    }
    
    /**
         * For a resource like : user/delete/{id}
         * Example of the query :
         * http://www.yourwebsite.com/user/delete/1
         */
    public function delete(ModelManager $modelManager, User $user): ResponseInterface 
    {
        // again $user will be a User Model corresponding to the user with
        // the id, 1 in the example. 
        
        // delete a specific user in the database
        $modelManager->delete($user);
        
        return new Response("User deleted");
    }
}
```

##Command
Hexacore allow you to create `Command`. Commands can use your already build services
and all hexacore features.

To create a command, create a new file in the `src/App/Command` folder. As controllers all commands' class must end with Command keyword.
```php
<?php

namespace App\Command;

use App\Model\User;
use App\Repository\UserRepository;
use Hexacore\Command\IO\ConsoleIO;
use Hexacore\Core\Config\JsonConfig;
use Hexacore\Core\Model\Manager\ModelManager;

class UserCommand
{
    /**
     * @param string $login
     * @param string $role
     * @param ModelManager $modelManager
     *
     * @param UserRepository $userRepository
     * @throws \ReflectionException
     */
    public function create(string $login, string $role, ModelManager $modelManager, UserRepository $userRepository)
    {
        $user = new User();

        $userCheck = $userRepository->findOneByLogin($login);

        if (null !== $userCheck) {
            throw new \Exception("User already exist");
        }

        ConsoleIO::writeLn('Enter password :');
        try {
            $password = ConsoleIO::readHidden();
        } catch (\Exception $e) {
            $password = ConsoleIO::read();
        }

        $password = password_hash($password . JsonConfig::getInstance()->setFile('app')->toArray()['secret'], PASSWORD_BCRYPT);

        $user
            ->setLogin($login)
            ->setPassword($password)
            ->setRole($role)
        ;

        $modelManager->persist($user);
    }

    /**
     * @param string $login
     * @param ModelManager $modelManager
     * @param UserRepository $userRepository
     * @throws \Exception
     */
    public function delete(string $login, ModelManager $modelManager, UserRepository $userRepository)
    {
        $user = $userRepository->findOneByLogin($login);

        if (null === $user) {
            throw new \Exception("User doesn't exist");
        }

        $modelManager->delete($user);
    }
}
```

This command allow you to create user and delete user.

You can run these command as shown below :
- `php System/command User:create Athena ADMIN_USER`
- `php System/command User:delete Athena`

You can also describe the command with annotations :

```php
...
class UserCommand
{
    /**
      * @Description("Create a new user")
      * @Argument\Required("User login [Athena]")
      * @Argument\Required("User role [ADMIN_USER]")
      * @Argument\Optional("Optional Argument")
      * @Example("php System/command User:create Zeus ROLE_USER optional")
      *  
      * @param string $login
      * @param string $role
      * @param ModelManager $modelManager
      *
      * @param UserRepository $userRepository
      * @throws \ReflectionException
     */
    public function create(string $login, string $role, ?string $optional, ModelManager $modelManager, UserRepository $userRepository)
...
```

This description can be shown using the `--help` ou `-h` flash :

`php System/command User:generate --help`


## Evolution

This project is developed for fun and may not be updated, but I see a lot of rooms for improvement :
- Add more unit tests to the framework
- Be able to add another templating system
- Login handler
- Associate Models together

For the future more test on several environments are required for example on nginx web server.

Also I'm not sure that auth and firewall will be usable in the future.