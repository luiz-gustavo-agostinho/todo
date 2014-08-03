<?php


namespace Todo\Tests\Unit\Persistence\File;


use Todo\Entity\Card;
use Todo\Persistence\File\Card as PersistenceCard;

class CardTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PersistenceCard
     */
    protected $persistence;

    public function setUp()
    {
        $this->persistence = new PersistenceCard();
    }


    public function testStoreRetrieve()
    {
        $card = new Card();
        $array = array(
            'id' => 1,
            'status' => 'x',
            'title' => 'Oh! pé',
        );
        $card->setId($array['id'])
            ->setStatus($array['status'])
            ->setTitle($array['title']);

        $persistence = $this->persistence;
        $isStored = $persistence->store($card);
        $this->assertTrue($isStored);

        $persistence = new PersistenceCard();
        $cardActual = $persistence->retrieve($card->getId());

        $this->assertEquals($card, $cardActual);
        $persistence->remove($card->getId());
    }

    public function testRetrieveInvalidCard()
    {
        $this->setExpectedException('RuntimeException');
        $persistence = $this->persistence;
        $persistence->retrieve(-10);
    }

    public function testRemoveInvalidCard()
    {
        $this->setExpectedException('Exception');
        $persistence = new PersistenceCard();
        $isRemoved = $persistence->remove(-10);
        $this->assertFalse($isRemoved);
    }
}
