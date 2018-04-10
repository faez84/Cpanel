<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 9/10/2017
 * Time: 12:56 AM
 */
namespace syndex\CpanelBundle\Model;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface QueryInterface
 */
interface QueryInterface
{
    /**
     * @param $args
     * @return mixed
     */
    public static function makeQuery($args);

}