<?php

namespace Todo\Tests\Unit\Request\Item;

class Add implements \Todo\Boundary\Item\Add
{
    protected $title;

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }
}
