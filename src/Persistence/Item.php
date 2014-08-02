<?php

namespace Todo\Persistence;

interface Item
{
    public function store(\Todo\Entity\Item $item);

    public function retrieve($key);
}
