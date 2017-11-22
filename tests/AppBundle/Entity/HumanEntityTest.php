<?php
/**
 * Created by PhpStorm.
 * User: genkovich
 * Date: 22.11.17
 * Time: 16:35
 */

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\HumanEntity;
use PHPUnit\Framework\TestCase;
use \InvalidArgumentException;
use \Throwable;
use \TypeError;


class HumanEntityTest extends TestCase
{
    public function testIntroduceYourself()
    {
        //arrange (подготовка)
        $human = new HumanEntity('Валентин', 25);

        //act (действие)
        $about = $human->introduceYourself();

        //assert (утверждение)
        $this->assertStringStartsWith('Меня зовут Валентин', $about);
    }

    /**
     * @dataProvider introduceYourselfExceptionsProvider
     *
     * @expectedException InvalidArgumentException
     *
     */
    public function testIntroduceYourselfExceptions($name, $age)
    {
        // или аннотация @expectedException InvalidArgumentException
        $this->expectException(InvalidArgumentException::class);
        $human = new HumanEntity($name, $age);
    }


    public function introduceYourselfExceptionsProvider()
    {
        return [
            ['', 25],
            ['Вася', -1],
        ];
    }

    /**
     * @dataProvider introduceYourselfErrorsProvider
     */
    public function testIntroduceYourselfErrors($name, $age)
    {
        try {
            $human = new HumanEntity($name, $age);
        } catch (Throwable $t) {
            $this->assertInstanceOf(TypeError::class, $t);
        }
    }


    public function introduceYourselfErrorsProvider()
    {
        return [
            ['', ''],
            [array(), ''],
            [0, array()],
        ];
    }
}