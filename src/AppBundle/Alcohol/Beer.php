<?php
/**
 * Created by PhpStorm.
 * User: genkovich
 * Date: 22.11.17
 * Time: 20:59
 */

namespace AppBundle\Alcohol;


class Beer extends Alcohol
{
    public function __construct()
    {
        $this->title = 'Пиво';
        $this->strong = 12;
    }


}