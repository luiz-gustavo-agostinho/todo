<?php


namespace Todo\Tests\Unit\Persistence\File;


use Todo\Entity\Item;
use Todo\Persistence\File\Item as PersistenceItem;

class ItemTest extends \PHPUnit_Framework_TestCase
{
    public function testStoreRetrieve()
    {
        $item = new Item();
        $array = array(
            'id' => 1,
            'status' => 'x',
            'title' => 'Oh! pé',
        );
        $item->setId($array['id'])
            ->setStatus($array['status'])
            ->setTitle($array['title']);

        $persistence = new PersistenceItem();
        $isStored = $persistence->store($item);
        $this->assertTrue($isStored);

        $persistence = new PersistenceItem();
        $itemActual = $persistence->retrieve($item->getId());

        $this->assertEquals($item, $itemActual);
    }

    public function testRetrieveInvalidItem()
    {
        $this->setExpectedException('RuntimeException');
        $persistence = new PersistenceItem();
        $persistence->retrieve(-10);
    }
}
 