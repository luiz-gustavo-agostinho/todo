<?php
namespace Todo\Persistence\File;

use Todo\Entity\Card as CardEntity;
use Todo\Persistence\Card as CardInterface;

class Card implements CardInterface
{
    protected $basePath = '/tmp/';

    protected function getPath($key)
    {
        return $this->basePath . str_replace('\\', '_', get_class($this)) . '-' . $key;
    }

    public function store(CardEntity $Card)
    {
        $key = $Card->getId();
        return (bool)file_put_contents($this->getPath($key), $Card->toJson());
    }

    public function retrieve($key)
    {
        $path = $this->getPath($key);
        if (!is_readable($path)) {
            throw new \RuntimeException('File not found or not readable: ' . $path);
        }

        $json = file_get_contents($path);
        $array = json_decode($json);
        $Card = new CardEntity();
        $Card->fromArray($array);
        return $Card;
    }
}
