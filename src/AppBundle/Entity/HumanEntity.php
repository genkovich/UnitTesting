<?php
/**
 * Created by PhpStorm.
 * User: genkovich
 * Date: 22.11.17
 * Time: 16:26
 */

namespace AppBundle\Entity;
use \InvalidArgumentException;

class HumanEntity
{
    private $name;
    private $age;

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
    }

    public function introduceYourself()
    {
        return 'Меня зовут ' . $this->name . '. Мне ' . $this->age . '.';
    }
}