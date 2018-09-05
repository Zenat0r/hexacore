<?php 

namespace App\Model;

use Hexacore\Core\Model\AbstractModel;


class UserModel extends AbstractModel
{
    protected $table = "user";
    
    private $id;
    private $name;
} 