<?php


namespace Todo\Tests\Unit\Persistence\File;


use Todo\Entity\Card;
use Todo\Persistence\File\Card as PersistenceCard;

class CardTest extends \PHPUnit_Framework_TestCase
{
    public function testStoreRetrieve()
    {
        $Card = new Card();
        $array = array(
            'id' => 1,
            'status' => 'x',
            'title' => 'Oh! pé',
        );
        $Card->setId($array['id'])
            ->setStatus($array['status'])
            ->setTitle($array['title']);

        $persistence = new PersistenceCard();
        $isStored = $persistence->store($Card);
        $this->assertTrue($isStored);

        $persistence = new PersistenceCard();
        $CardActual = $persistence->retrieve($Card->getId());

        $this->assertEquals($Card, $CardActual);
    }

    public function testRetrieveInvalidCard()
    {
        $this->setExpectedException('RuntimeException');
        $persistence = new PersistenceCard();
        $persistence->retrieve(-10);
    }
}
 