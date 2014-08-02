<?php


namespace Todo\Tests\Unit\Entity;


use Todo\Entity\Item;

class ItemTest extends \PHPUnit_Framework_TestCase
{
    public function testToJson()
    {
        $item = new Item();
        $array = array(
          'id' => 1,
          'status' => 'x',
          'title' => 'Oh! pé',
        );
        $jsonExpected = json_encode($array, true);

        $item->setId($array['id'])
            ->setStatus($array['status'])
            ->setTitle($array['title']);
        $jsonActual = $item->toJson();

        $this->assertJson($jsonActual);
        $this->assertEquals($jsonExpected, $jsonActual);
    }
}
 