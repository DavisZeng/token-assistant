<?php
/**
 * @filename LoginStatisticsTest.php
 * @touch    09/11/2016 21:12
 * @author   wudege <hi@wudege.me>
 * @version  1.0.0
 */

namespace TokenAssistant\Tests;


use TokenAssistant\LoginStatistics;

class LoginStatisticsTest extends BaseTestCase
{
    /**
     * @var LoginStatistics
     */
    protected $stat;

    /**
     * Current Time
     */
    protected $time;

    /**
     *
     * @author wudege <hi@wudege.me>
     */
    public function setUp()
    {
        parent::setUp();
        $this->stat = new LoginStatistics($this->client);
        $this->time = time();
    }

    /**
     *
     * @author wudege <hi@wudege.me>
     */
    public function testRefresh()
    {
        $token = $this->dispatcher->assign(self::TEST_USER_ID);
        $this->assertNotEmpty($token);
        $bool = $this->stat->refresh(self::TEST_USER_ID, $this->time);
        $this->assertTrue($bool);
    }

    /**
     *
     * @author  wudege <hi@wudege.me>
     * @depends testRefresh
     */
    public function testCountUsers()
    {
        $startTimestamp = $this->time - 1;
        $endTimestamp   = $this->time + 1;
        $num            = $this->stat->countUsers($startTimestamp, $endTimestamp);
        $this->assertEquals(1, (int)$num);
    }

    /**
     *
     * @author  wudege <hi@wudege.me>
     * @depends testRefresh
     */
    public function testListUsers()
    {
        $startTimestamp = $this->time - 1;
        $endTimestamp   = $this->time + 1;
        $userIds        = $this->stat->listUsers($startTimestamp, $endTimestamp);
        $this->assertEquals(1, count($userIds));
    }

    /**
     *
     * @author  wudege <hi@wudege.me>
     * @depends testRefresh
     */
    public function testLastVisited()
    {
        $time = $this->stat->lastVisited(self::TEST_USER_ID);
        $this->assertEquals($this->time, $time);
    }

    /**
     *
     * @author wudege <hi@wudege.me>
     */
    public function tearDown()
    {
        parent::tearDown();
        unset($this->stat);
    }
}