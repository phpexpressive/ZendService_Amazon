<?php
/**
 * @see       https://github.com/zendframework/ZendService_Amazon for the canonical source repository
 * @copyright Copyright (c) 2005-2017 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/ZendService_Amazon/blob/master/LICENSE.md New BSD License
 */

namespace ZendServiceTest\Amazon\Ec2;

use PHPUnit\Framework\TestCase;
use ZendService\Amazon;
use ZendService\Amazon\Ec2\Exception\InvalidArgumentException;

/**
 * @category   Zend
 * @package    Zend_Service_Amazon
 * @subpackage UnitTests
 * @group      Zend_Service
 * @group      Zend_Service_Amazon
 * @group      Zend_Service_Amazon_Ec2
 */
class AbstractTest extends TestCase
{
    public function testSetRegion()
    {
        $ec2 = new TestAmazonAbstract('TestAccessKey', 'TestSecretKey');
        $ec2->setRegion('eu-west-1');
        $this->assertEquals('eu-west-1', $ec2->returnRegion());
    }

    public function testSetInvalidRegionThrowsException()
    {
        $ec2 = new TestAmazonAbstract('TestAccessKey', 'TestSecretKey');
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Amazon Ec2 Region');
        $ec2->setRegion('eu-west-1a');
    }

    public function testSignParamsWithSpaceEncodesWithPercentInsteadOfPlus()
    {
        $class = new TestAmazonAbstract('TestAccessKey', 'TestSecretKey');
        $ret = $class->testSign(['Action' => 'Space Test']);

        // this is the encode signuature with urlencode - It's Invalid!
        $invalidSignature = 'EeHAfo7cMcLyvH4SW4fEpjo51xJJ4ES1gdjRPxZTlto=';

        $this->assertNotEquals($ret, $invalidSignature);
    }
}
