<?php

namespace Todo\Boundary\Item;

interface Update
{
    public function getId();

    public function getTitle();

    public function toArray();
}
