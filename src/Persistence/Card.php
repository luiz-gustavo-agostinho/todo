<?php

namespace Todo\Persistence;

interface Card
{
    public function store(\Todo\Entity\Card $Card);

    public function retrieve($key);
}
