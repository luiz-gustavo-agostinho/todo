<?php

namespace Todo\Tests\Unit\Interactor;

use Todo\Interactor\Card;
use Todo\Tests\Unit\Request\Card\Add;
use Todo\Tests\Unit\Request\Card\Get;
use Todo\Tests\Unit\Request\Card\Update;

class CardTest extends \PHPUnit_Framework_TestCase
{
    public function testAdd()
    {
        $interactor = new Card();
        $request = new Add();

        $title = 'comprar um programa de TV';
        $request->setTitle($title);
        $result = $interactor->add($request);

        $this->assertInstanceOf('\Todo\Boundary\Result', $result);
        $this->assertTrue($result->getBoolean());
        $this->assertTrue($result->getId() > 0);

        $persistence = new \Todo\Persistence\File\Card();
        $retrieveResult = $persistence->retrieve($result->getId());
        $this->assertEquals($title, $retrieveResult->getTitle());
    }

    public function testAddFailStore()
    {
        $interactor = new Card();
        $request = new Add();

        // mock store fail
        $stub = $this->getMock('\Todo\Persistence\File\Card');
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
        $CardIteractor = new Card();

        $requestAdd->setTitle('Kill Bill');
        $addResult = $CardIteractor->add($requestAdd);

        $requestUpdate->setId($addResult->getId())
            ->setTitle('Kill Adama');

        $updateResult = $CardIteractor->update($requestUpdate);

        $this->assertEquals($addResult->getId(), $updateResult->getId());
        $this->assertEquals($requestUpdate->getTitle(), $updateResult->getTitle());
        $this->assertTrue($updateResult->getBoolean());
    }

    public function testGet()
    {
        $requestAdd = new Add();
        $requestGet = new Get();
        $CardInteractor = new Card();

        $requestAdd->setTitle('store this please Mr. Pericles');
        $addResult = $CardInteractor->add($requestAdd);

        $requestGet->setId($addResult->getId());

        $getResult = $CardInteractor->get($requestGet);
        $this->assertTrue($getResult->getBoolean());
        $this->assertEquals($getResult->getId(), $addResult->getId());
        $this->assertEquals($getResult->getTitle(), $requestAdd->getTitle());
        $this->assertEquals($getResult->getStatus(), 1);


    }
}