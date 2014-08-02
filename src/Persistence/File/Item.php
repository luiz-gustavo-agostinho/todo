<?php
namespace Todo\Persistence\File;

use Todo\Entity\Item as ItemEntity;
use Todo\Persistence\Item as ItemInterface;

class Item implements ItemInterface
{
    protected $basePath = '/tmp/';

    protected function getPath($key)
    {
        return $this->basePath . str_replace('\\', '_', get_class($this)) . '-' . $key;
    }

    public function store(ItemEntity $item)
    {
        $key = $item->getId();
        return (bool)file_put_contents($this->getPath($key), $item->toJson());
    }

    public function retrieve($key)
    {
        $path = $this->getPath($key);
        if (!is_readable($path)) {
            throw new \RuntimeException('File not found or not readable: ' . $path);
        }

        $json = file_get_contents($path);
        $array = json_decode($json);
        $item = new ItemEntity();
        $item->fromArray($array);
        return $item;
    }
}
