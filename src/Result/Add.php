<?php

namespace Todo\Result;

use Todo\Boundary\Result;
use Todo\Entity\DataConversion;

class Add implements Result
{
    use DataConversion;

    protected $id;
    protected $boolean;

    public function __construct($boolean, $id)
    {
        $this->boolean = $boolean;
        $this->id = $id;
    }

    public function getBoolean()
    {
        return $this->boolean;
    }

    public function getId()
    {
        return $this->id;
    }
}
