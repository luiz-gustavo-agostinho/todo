<?php

namespace Todo\Interactor;

use Todo\Boundary\Item\Add;
use Todo\Boundary\Item\Get;
use Todo\Boundary\Item\Update;
use Todo\Entity\Item as ItemEntity;
use Todo\Persistence\File\Item as PersistenceItem;
use Todo\Result\Add as AddResult;

class Item
{
    protected $persistenceItem;

    public function add(Add $requestAdd)
    {
        $item = new ItemEntity();
        $generatedId = time();
        $item->setId($generatedId);
        $item->setTitle($requestAdd->getTitle());
        $item->setStatus(1);

        $persistence = $this->getPersistence();
        $isStored = $persistence->store($item);
        if (!$isStored) {
            $generatedId = null;
        }
        $result = new AddResult($isStored, $generatedId);

        return $result;
    }

    public function update(Update $requestUpdate)
    {
        $persistence = $this->getPersistence();
        $item = $persistence->retrieve($requestUpdate->getId());

        $item->fromArray($requestUpdate->toArray());
        $isStored = $persistence->store($item);

        $updateResult = new \Todo\Result\Update($isStored, $item->getId());
        $updateResult->setTitle($item->getTitle());

        return $updateResult;
    }

    public function get(Get $requestGet)
    {
        $persistence = $this->getPersistence();
        $item = $persistence->retrieve($requestGet->getId());

        $getResult = new \Todo\Result\Get(true, $item->getId());
        $getResult->setTitle($item->getTitle());
        $getResult->setStatus($item->getStatus());

        return $getResult;
    }

    public function setPersistence(\Todo\Persistence\Item $persistenceItem)
    {
        $this->persistenceItem = $persistenceItem;
    }

    /**
     * @return PersistenceItem
     */
    public function getPersistence()
    {
        if (!isset($this->persistenceItem)) {
            $this->persistenceItem = new PersistenceItem();
        }

        return $this->persistenceItem;
    }
}
