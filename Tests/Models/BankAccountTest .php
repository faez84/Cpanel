<?php
/**
 * Created by PhpStorm.
 * User: Fayez
 * Date: 2/22/2018
 * Time: 11:40 PM
 */
namespace syndex\CpanelBundle\Tests\Models;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use syndex\CpanelBundle\Util\BankAccount;

class BankAccountTest extends WebTestCase
{
    public $ba;
//
//    public function setUp()
//    {
//        $this->ba = new BankAccount();
//
//    }
//
//    /**
//     * @covers syndex\CpanelBundle\Util\BankAccount::getBalance
//     */
//    public function testBalanceIsInitiallyZero()
//    {
//        $this->assertEquals(4, $this->ba->getBalance());
//    }
//
//    /**
//     * @covers syndex\CpanelBundle\Util\BankAccount::withdrawMoney
//     */
//    public function testBalanceCannotBecomeNegative()
//    {
//        try {
//            $this->ba->withdrawMoney(1);
//        }
//
//        catch (BankAccountException $e) {
//            $this->assertEquals(4, $this->ba->getBalance());
//
//            return;
//        }
//
//     //   $this->fail();
//    }
//
//    /**
//     * @covers syndex\CpanelBundle\Util\BankAccount::depositMoney
//     */
//    public function testBalanceCannotBecomeNegative2()
//    {
//        try {
//            $this->ba->depositMoney(-1);
//        }
//
//        catch (BankAccountException $e) {
//            $this->assertEquals(4, $this->ba->getBalance());
//
//            return;
//        }
//
////        $this->fail();
//    }
//
//    /**
//     * @covers syndex\CpanelBundle\Util\BankAccount::getBalance
//     * @covers syndex\CpanelBundle\Util\BankAccount::depositMoney
//     * @covers syndex\CpanelBundle\Util\BankAccount::withdrawMoney
//     */
//    public function testDepositWithdrawMoney()
//    {
//        $this->assertEquals(4, $this->ba->getBalance());
//        $this->ba->depositMoney(1);
//        $this->assertEquals(4, $this->ba->getBalance());
//        $this->ba->withdrawMoney(1);
//        $this->assertEquals(4, $this->ba->getBalance());
//    }

    public function testAdd()
    {
        $calc = new BankAccount();
        $result = $calc->add(30, 12);
// assert that your calculator added the numbers correctly!
        $this->assertEquals(42, $result);
    }
}