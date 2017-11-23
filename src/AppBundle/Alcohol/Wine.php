<?php
/**
 * Created by PhpStorm.
 * User: genkovich
 * Date: 22.11.17
 * Time: 21:01
 */

namespace AppBundle\Alcohol;


class Wine extends Alcohol
{
    public function __construct()
    {
        $this->title = 'Винишко';
        $this->strong = 20;
    }

    public function getTemperature() {
        return 10;
    }

    public function showEnv()
    {
        $temperature = $this->getTemperature();
        $title = $this->getTitle();
        return $title . $temperature;

    }
}