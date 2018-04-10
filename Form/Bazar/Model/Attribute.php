<?php
/**
 * Created by PhpStorm.
 * User: LUFFY
 * Date: 14/08/2016
 * Time: 01:11 م
 */

namespace syndex\BazaarBundle\Form\Bazar\Model;


class Attribute
{

    private $name;

    private $value;

    function getName()
    {
        return $this->name;
    }

    function setName($name)
    {
        $this->name = $name;
    }

    function getValue()
    {
        return $this->value;
    }

    function setValue($value)
    {
        $this->value = $value;
    }

}