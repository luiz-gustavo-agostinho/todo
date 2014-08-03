<?php

namespace Todo\Interactor;

use Todo\Boundary\Card\Add;
use Todo\Boundary\Card\Get;
use Todo\Boundary\Card\Update;
use Todo\Entity\Card as CardEntity;
use Todo\Persistence\File\Card as PersistenceCard;
use Todo\Result\Add as AddResult;

class Card
{
    protected $persistenceCard;

    public function add(Add $requestAdd)
    {
        $Card = new CardEntity();
        $generatedId = time();
        $Card->setId($generatedId);
        $Card->setTitle($requestAdd->getTitle());
        $Card->setStatus(1);

        $persistence = $this->getPersistence();
        $isStored = $persistence->store($Card);
        if (!$isStored) {
            $generatedId = null;
        }
        $result = new AddResult($isStored, $generatedId);

        return $result;
    }

    public function update(Update $requestUpdate)
    {
        $persistence = $this->getPersistence();
        $Card = $persistence->retrieve($requestUpdate->getId());

        $Card->fromArray($requestUpdate->toArray());
        $isStored = $persistence->store($Card);

        $updateResult = new \Todo\Result\Update($isStored, $Card->getId());
        $updateResult->setTitle($Card->getTitle());

        return $updateResult;
    }

    public function get(Get $requestGet)
    {
        $persistence = $this->getPersistence();
        $Card = $persistence->retrieve($requestGet->getId());

        $getResult = new \Todo\Result\Get(true, $Card->getId());
        $getResult->setTitle($Card->getTitle());
        $getResult->setStatus($Card->getStatus());

        return $getResult;
    }

    public function setPersistence(\Todo\Persistence\Card $persistenceCard)
    {
        $this->persistenceCard = $persistenceCard;
    }

    /**
     * @return PersistenceCard
     */
    public function getPersistence()
    {
        if (!isset($this->persistenceCard)) {
            $this->persistenceCard = new PersistenceCard();
        }

        return $this->persistenceCard;
    }
}
