<?php


namespace Todo\Tests\Unit\Request\Item;


class Get implements \Todo\Boundary\Item\Get
{
    protected $id;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
}
