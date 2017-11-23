<?php
/**
 * Created by PhpStorm.
 * User: genkovich
 * Date: 22.11.17
 * Time: 16:26
 */

namespace AppBundle\Entity;
use AppBundle\Alcohol\Alcohol;
use \InvalidArgumentException;

class HumanEntity
{
    private $name;
    private $age;
    private $drinks;
    private $currentAlcohol;

    public function __construct(string $name, int $age)
    {
        if (empty($name)) {
            throw new InvalidArgumentException('У человека должно быть имя');
        }

        if ($age < 0) {
            throw new InvalidArgumentException('Не бывает отрицательного возраста');
        }

        $this->name = $name;
        $this->age = $age;
        $this->drinks = [];
    }

    public function introduceYourself()
    {
        return 'Меня зовут ' . $this->name . '. Мне ' . $this->age . '.';
    }

    public function drinkAlcohol(Alcohol $alcohol)
    {
        $this->drinks[] = $alcohol;
    }

    public function whatIDrink() {
        return $this->drinks;
    }

    public function takeAlcohol(Alcohol $alcohol)
    {
        $this->currentAlcohol = $alcohol;
    }

    public function diluteAlcohol() {
        return $this->currentAlcohol->downAlcohol();
    }


}