<?php 

namespace App\Model;

use Hexacore\Core\Model\AbstractModel;
use Hexacore\Core\Model\StorageTrait;

class UserModel extends AbstractModel
{
    use StorageTrait;
    
    protected $table = "user";
    
    protected $id;
    protected $name;
} 