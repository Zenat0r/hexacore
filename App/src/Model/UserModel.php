<?php 

namespace App\Model;

use Hexacore\Core\Model\QueryBuilder;
use Hexacore\Core\Model\StorageTrait;

class UserModel extends QueryBuilder
{
    use StorageTrait;
    
    protected $table = "user";
    
    protected $id;
    protected $name;
} 