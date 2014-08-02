<?php


namespace Todo\Tests\Unit\Request\Item;


use Todo\Entity\DataConversion;

class Get implements \Todo\Boundary\Item\Get
{
    use DataConversion;

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
