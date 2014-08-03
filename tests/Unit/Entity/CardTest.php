<?php


namespace Todo\Tests\Unit\Entity;


use Todo\Entity\Card;

class CardTest extends \PHPUnit_Framework_TestCase
{
    public function testToJson()
    {
        $Card = new Card();
        $array = array(
            'id' => 1,
            'status' => 'x',
            'title' => 'Oh! pé',
        );
        $jsonExpected = json_encode($array, true);

        $Card->setId($array['id'])
            ->setStatus($array['status'])
            ->setTitle($array['title']);
        $jsonActual = $Card->toJson();

        $arrayExpected = json_decode($jsonExpected, true);
        $arrayActual = json_decode($jsonActual, true);

        $this->assertJson($jsonActual);
        $this->assertEquals($arrayExpected, $arrayActual);
    }
}
