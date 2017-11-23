<?php
/**
 * Created by PhpStorm.
 * User: genkovich
 * Date: 22.11.17
 * Time: 20:54
 */

namespace AppBundle\Alcohol;

abstract class Alcohol
{
    protected $title;
    protected $strong;

    public function getStrong() {
        return $this->strong;
    }

    public function getTitle() {
        return $this->title;
    }
}