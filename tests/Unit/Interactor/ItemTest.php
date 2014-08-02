<?php

namespace Todo\Tests\Unit\Interactor;

use \Todo\Tests\Unit\Request\Item\Add;

use \Todo\Interactor\Item;
use Todo\Tests\Unit\Request\Item\Get;
use Todo\Tests\Unit\Request\Item\Update;

class ItemTest extends \PHPUnit_Framework_TestCase
{
    public function testAdd()
    {
        $interactor = new Item();
        $request = new Add();

        $title = 'comprar um programa de TV';
        $request->setTitle($title);
        $result = $interactor->add($request);

        $this->assertInstanceOf('\Todo\Boundary\Result', $result);
        $this->assertTrue($result->getBoolean());
        $this->assertTrue($result->getId() > 0);

        $persistence = new \Todo\Persistence\File\Item();
        $retrieveResult = $persistence->retrieve($result->getId());
        $this->assertEquals($title, $retrieveResult->getTitle());
    }

    public function testAddFailStore()
    {
        $interactor = new Item();
        $request = new Add();

        // mock store fail
        $stub = $this->getMock('\Todo\Persistence\File\Item');
        $stub->expects($this->once())
            ->method('store')
            ->will($this->returnValue(false));

        $interactor->setPersistence($stub);

        $title = 'comprar um programa de TV';
        $request->setTitle($title);
        $result = $interactor->add($request);

        $this->assertInstanceOf('\Todo\Boundary\Result', $result);
        $this->assertFalse($result->getBoolean());
    }


    public function testUpdate()
    {
        $requestAdd = new Add();
        $requestUpdate = new Update();
        $itemIteractor = new Item();

        $requestAdd->setTitle('Kill Bill');
        $addResult = $itemIteractor->add($requestAdd);

        $requestUpdate->setId($addResult->getId())
            ->setTitle('Kill Adama');

        $updateResult = $itemIteractor->update($requestUpdate);

        $this->assertEquals($addResult->getId(), $updateResult->getId());
        $this->assertEquals($requestUpdate->getTitle(), $updateResult->getTitle());
        $this->assertTrue($updateResult->getBoolean());
    }

    public function testGet()
    {
        $requestAdd = new Add();
        $requestGet = new Get();
        $itemInteractor = new Item();

        $requestAdd->setTitle('store this please Mr. Pericles');
        $addResult = $itemInteractor->add($requestAdd);

        $requestGet->setId($addResult->getId());

        $getResult = $itemInteractor->get($requestGet);
        $this->assertTrue($getResult->getBoolean());
        $this->assertEquals($getResult->getId(), $addResult->getId());
        $this->assertEquals($getResult->getTitle(), $requestAdd->getTitle());
        $this->assertEquals($getResult->getStatus(), 1);


    }
}