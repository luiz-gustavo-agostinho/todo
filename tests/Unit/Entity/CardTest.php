<?php


namespace Todo\Tests\Unit\Entity;


use Todo\Entity\Card;

class CardTest extends \PHPUnit_Framework_TestCase
{
    public function testToJson()
    {
        $card = new Card();
        $array = array(
            'id' => 1,
            'status' => 'x',
            'title' => 'Oh! pé',
        );
        $jsonExpected = json_encode($array, true);

        $card->setId($array['id'])
            ->setStatus($array['status'])
            ->setTitle($array['title']);
        $jsonActual = $card->toJson();

        $arrayExpected = json_decode($jsonExpected, true);
        $arrayActual = json_decode($jsonActual, true);

        $this->assertJson($jsonActual);
        $this->assertEquals($arrayExpected, $arrayActual);
    }
}
