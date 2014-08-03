<?php

namespace Todo\Persistence;

interface Card
{
    public function store(\Todo\Entity\Card $card);

    public function retrieve($id);

    public function remove($id);

    public function generateKey($id);
}
