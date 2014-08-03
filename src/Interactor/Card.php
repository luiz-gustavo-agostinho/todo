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
        $card = new CardEntity();
        $generatedId = time();
        $card->setId($generatedId);
        $card->setTitle($requestAdd->getTitle());
        $card->setStatus(1);

        $persistence = $this->getPersistence();
        $isStored = $persistence->store($card);
        if (!$isStored) {
            $generatedId = null;
        }
        $result = new AddResult($isStored, $generatedId);

        return $result;
    }

    public function update(Update $requestUpdate)
    {
        $persistence = $this->getPersistence();
        $card = $persistence->retrieve($requestUpdate->getId());

        $card->fromArray($requestUpdate->toArray());
        $isStored = $persistence->store($card);

        $updateResult = new \Todo\Result\Update($isStored, $card->getId());
        $updateResult->setTitle($card->getTitle());

        return $updateResult;
    }

    public function get(Get $requestGet)
    {
        $persistence = $this->getPersistence();
        $card = $persistence->retrieve($requestGet->getId());

        $getResult = new \Todo\Result\Get(true, $card->getId());
        $getResult->setTitle($card->getTitle());
        $getResult->setStatus($card->getStatus());

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
