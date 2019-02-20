<?php
/**
 * Created by PhpStorm.
 * User: lucas.silva
 * Date: 2019-02-20
 * Time: 13:15
 */

class HelloTest extends \PHPUnit\Framework\TestCase
{
    public function testHello(): void {
        $this->assertEquals(true, 1==1);
    }
}