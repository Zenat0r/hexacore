<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 17/03/19
 * Time: 21:03
 */

namespace Hexacore\Core\Model\Manager;


use Hexacore\Core\Model\ManageableModelInterface;

interface ModelManagerInterface
{
    public function persist(ManageableModelInterface $model);
}