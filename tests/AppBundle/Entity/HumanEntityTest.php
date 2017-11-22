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

}