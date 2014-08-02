<?php

namespace Todo\Tests\Unit\Request\Item;

use Todo\Entity\DataConversion;

class Add implements \Todo\Boundary\Item\Add
{
    use DataConversion;

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
