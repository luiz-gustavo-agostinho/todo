<?php

namespace Todo\Result;

use \Todo\Boundary\Result;

class Update implements Result
{
    protected $id;
    protected $boolean;
    protected $title;

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
}