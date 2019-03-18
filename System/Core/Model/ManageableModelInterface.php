<?php
/**
 * Created by PhpStorm.
 * User: christophe
 * Date: 17/03/19
 * Time: 21:04
 */

namespace Hexacore\Core\Model;


/**
 * Every implementation of the interface will be usable with
 * the ModelManager and ModelRepository.
 *
 * Interface ManageableModelInterface
 * @package Hexacore\Core\Model
 */
interface ManageableModelInterface
{
    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @param int $id
     * @return ManageableModelInterface
     */
    public function setId(int $id): ManageableModelInterface;
}