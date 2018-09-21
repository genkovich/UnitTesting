<?php
/**
 * Created by PhpStorm.
 * User: genkovich
 * Date: 23.11.17
 * Time: 17:47
 */

namespace Tests\AppBundle\Entity;


use AppBundle\Alcohol\Beer;
use AppBundle\Alcohol\Wine;
use AppBundle\Entity\HumanEntity;
use PHPUnit\Framework\TestCase;

class MockTest extends TestCase
{
    public function testStub()
    {
        // Create a stub for the SomeClass class.
        $stub = $this->createMock(HumanEntity::class);
        // Create a map of arguments to return values.
        $map = [
            ['a', 'b'],
        ];
       $stub->method('introduceYourself')
        ->will($this->returnValueMap($map));



        // Calling $stub->doSomething() will now return
        // 'foo'.
        $this->assertEquals('b', $stub->introduceYourself('a'));
    }


    public function testDrinks()
    {
        $mock = $this->getMockBuilder(Beer::class)
            ->setMethods(['downAlcohol'])
            ->getMock();

        $mock->expects($this->once())
            ->method('downAlcohol');

        $human = new HumanEntity('Николай', 35);
        $human->takeAlcohol($mock);
        $human->diluteAlcohol();

    }


    public function testAt()
    {
        $mock = $this->getMockBuilder(Wine::class)
            ->setMethods(['getTitle', 'getTemperature',])
            ->getMock();


//        $mock->expects($this->once())->method('getTitle');
//        $mock->expects($this->once())->method('getTemperature');

        $mock->expects($this->at(1))->method('getTitle');
        $mock->expects($this->at(0))->method('getTemperature');

        $mock->showEnv();
    }

}