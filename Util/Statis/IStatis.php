<?php
namespace syndex\CpanelBundle\Util\Statis;
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 3/8/2018
 * Time: 3:49 PM
 */

/**
 * Interface AdminInterface
 */
interface IStatis
{
    const ENTITY_SYMBOL = "e";

    /**
     * @param $result
     * @return mixed
     */
    public function execute(&$result);
}