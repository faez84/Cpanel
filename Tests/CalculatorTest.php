<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 9/8/2017
 * Time: 3:07 PM
 */

namespace syndex\CpanelBundle\Tests;
use syndex\CpanelBundle\Util\Calculator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use syndex\CpanelBundle\Util\BankAccount;

class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testAccdd()
    {
        $calc = new BankAccount();
        $result = $calc->add(30, 12);
// assert that your calculator added the numbers correctly!
        $this->assertEquals(42, $result);
    }
}