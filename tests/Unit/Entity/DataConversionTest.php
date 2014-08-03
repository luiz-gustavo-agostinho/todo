<?php


namespace Todo\Tests\Unit\Entity;


use Todo\Result\Add;

class DataConversionTest extends \PHPUnit_Framework_TestCase
{
    public function testFromJson()
    {
        $data = array(
            'id' => 1,
            'boolean' => true
        );

        $jsonData = json_encode($data);
        $resultAdd = new Add(true, 1);
        $resultAdd->fromJson($jsonData);

        $actualData = $resultAdd->toArray();

        $this->assertEquals($data, $actualData);
    }
}
