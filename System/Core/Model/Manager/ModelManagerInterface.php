<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 17/03/19
 * Time: 21:03
 */

namespace Hexacore\Core\Model\Manager;


use Hexacore\Core\Model\ManageableModelInterface;

/**
 * Implementation of this class must be responsible for the life cycle of
 * all model that implement ManageableModelInterface.
 * That mean creation -> update -> destruction
 *
 * Interface ModelManagerInterface
 * @package Hexacore\Core\Model\Manager
 */
interface ModelManagerInterface
{
    /**
     * Persist must update of create the ManageableModel directly to the database
     *
     * @param ManageableModelInterface $model
     * @return mixed
     */
    public function persist(ManageableModelInterface $model);

    /**
     * Delete must remove from the database the corresponding ManageableModel
     *
     * @param ManageableModelInterface $model
     * @return mixed
     */
    public function delete(ManageableModelInterface $model);
}