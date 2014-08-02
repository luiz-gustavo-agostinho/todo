<?php

namespace Todo\Result;

use Todo\Boundary\Result;
use Todo\Entity\DataConversion;

class Get implements Result
{
    use DataConversion;

    protected $id;
    protected $boolean;
    protected $title;
    protected $status;

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

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}
