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
    /**
     * @expectedException InvalidArgumentException
     */
    public function testIntroduceYourselfExceptions()
    {
        $this->expectException(InvalidArgumentException::class);
        $human = new HumanEntity('', 42);
    }

    /**
     * @dataProvider introduceYourselfErrorsProvider
     *
     * @depends testIntroduceYourselfExceptions
     */
    public function testIntroduceYourselfErrors($name, $age)
    {
        try {
            $human = new HumanEntity($name, $age);
        } catch (Throwable $t) {
        }
        $this->assertInstanceOf(TypeError::class, $t);
    }


    public function introduceYourselfErrorsProvider()
    {
        return [
            ['', ''],
            [array(), ''],
            [0, array()],
        ];
    }

    /**
     * @depends testIntroduceYourselfErrors
     */
    public function testIntroduceYourself()
    {
        //arrange (подготовка)
        $human = new HumanEntity('Валентин', 25);

        //act (действие)
        $about = $human->introduceYourself();

        //assert (утверждение)
        $this->assertStringStartsWith('Меня зовут Валентин', $about);
    }
}