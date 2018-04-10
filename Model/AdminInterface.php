<?php

/**
 * @author Faz <faz@gmail.com>
 */
namespace syndex\CpanelBundle\Model;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface AdminInterface
 * @package syndex\CpanelBundle\Model
 */
interface AdminInterface
{
    const ITEMS_COUNT = 20;

    /**
     * @param Request $request
     * @return mixed
     */
    public function showAction(Request $request);

    /**
     * @param Request $request
     * @param $page
     * @return mixed
     */
    public function listAction(Request $request, $page);

}
