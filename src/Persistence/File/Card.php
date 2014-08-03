<?php
namespace Todo\Persistence\File;

use Todo\Entity\Card as CardEntity;
use Todo\Persistence\Card as CardInterface;

class Card implements CardInterface
{
    protected $basePath = '/tmp/';

    protected function getPath($id)
    {
        return $this->basePath . $this->generateKey($id);
    }

    public function generateKey($id)
    {
        return str_replace('\\', '_', get_class($this)) . '-' . $id;
    }

    public function store(CardEntity $card)
    {
        $id = $card->getId();
        return (bool)file_put_contents($this->getPath($id), $card->toJson());
    }

    public function retrieve($id)
    {
        $path = $this->getPath($id);
        if (!is_readable($path)) {
            throw new \RuntimeException('File not found or not readable: ' . $path);
        }

        $json = file_get_contents($path);
        $array = json_decode($json);
        $card = new CardEntity();
        $card->fromArray($array);
        return $card;
    }

    public function remove($id)
    {
        $path = $this->getPath($id);
        return unlink($path);
    }
}
