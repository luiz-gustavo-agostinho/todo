<?php

namespace Todo\Tests\Unit\Request\Item;
use \Todo\Boundary\Item\Update as UpdateBoundary;

class Update implements UpdateBoundary
{
    protected $title;
    protected $id;

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function toArray()
    {
        $properties = get_class_vars(__CLASS__);
        $array = array();

        foreach ($properties as $prop => $null) {
            $method = 'get' . ucfirst($prop);
            if (method_exists($this, $method)) {
                $array[$prop] = $this->$method();
            }
        }

        return $array;
    }
}
