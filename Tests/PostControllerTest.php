<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 9/8/2017
 * Time: 3:04 PM
 */

namespace syndex\CpanelBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;
/**
 * Class PostControllerTest
 * @package syndex\CpanelBundle\Tests
 */
class PostControllerTest extends TestCase
{
    public function testProducerFirst()
    {
        $this->assertTrue(true);
        return 'first';
    }

    public function testProducerSecond()
    {
        $this->assertTrue(true);
        return 'second';
    }

    /**
     * @depends testProducerFirst
     * @depends testProducerSecond
     */
    public function testConsumer()
    {
        $this->assertEquals(
            ['first', 'second'],
            func_get_args()
        );
    }
}