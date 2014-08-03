<?php

namespace Todo\Tests\Unit\Request\Card;

use Todo\Boundary\Card\Update as UpdateBoundary;
use Todo\Entity\DataConversion;

class Update implements UpdateBoundary
{
    use DataConversion;

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
}
