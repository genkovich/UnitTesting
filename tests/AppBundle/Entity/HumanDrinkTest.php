<?php
/**
 * Created by PhpStorm.
 * User: genkovich
 * Date: 23.11.17
 * Time: 16:18
 */

namespace Tests\AppBundle\Entity;


use AppBundle\Alcohol\Beer;
use AppBundle\Alcohol\Wine;
use AppBundle\Entity\HumanEntity;
use PHPUnit\Framework\TestCase;


class HumanDrinkTest extends TestCase
{

    private $human;

    protected function setUp()
    {
        $this->human = new HumanEntity('Вася', 42);
    }

    protected function tearDown() {
        $this->human = NULL;
    }

    /**
     * @dataProvider drinksProvider
     */
    public function testWhatHumanDrink($alcohol)
    {
        $this->human->drinkAlcohol($alcohol);
        $this->assertCount(1, $this->human->whatIDrink());
    }

    public function drinksProvider()
    {
        return [
            [new Beer()],
            [new Wine()],
            [new Beer()],
            [new Beer()],
        ];
    }
}