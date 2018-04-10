<?php
/**
 * Created by PhpStorm.
 * User: LUFFY
 * Date: 11/08/2016
 * Time: 05:47 م
 */

namespace syndex\CpanelBundle\Services;


use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query\Expr\Join;
use syndex\CpanelBundle\Model\HelperClass;
use Doctrine\Common\Cache\RedisCache;

/**
 * Class StatsService
 * @package syndex\CpanelBundle\Services
 */
class CacheService
{

    private $cache;

    /**
     * StatsService constructor.
     * @param ObjectManager $em
     */
    public function __construct(RedisCache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param $settings
     * @param $entity
     * @return mixed
     */
    public function saveData($data, $key)
    {
        $this->cache->save($key, $data, 85400);
    }

    /**
     * @param $key
     * @return false|mixed
     */

    public function getData($key){
        return $this->cache->fetch($key);
    }
    public function readData(){
        return $this->cache->fetch("4");
    }
}