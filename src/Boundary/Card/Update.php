<?php

namespace Todo\Boundary\Card;

interface Update
{
    public function getId();

    public function getTitle();

    public function toArray();
}
