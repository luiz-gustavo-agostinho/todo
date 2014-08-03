<?php


namespace Todo\Tests\Unit\Request\Card;


use Todo\Entity\DataConversion;

class Get implements \Todo\Boundary\Card\Get
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
