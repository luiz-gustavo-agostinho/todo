<?php

namespace Todo\Tests\Unit\Interactor;

use Todo\Interactor\Card;
use Todo\Persistence\File\Card as CardPersistence;
use Todo\Tests\Unit\Request\Card\Add;
use Todo\Tests\Unit\Request\Card\Get;
use Todo\Tests\Unit\Request\Card\Update;

class CardTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CardPersistence
     */
    protected $persistence;

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

        $persistence = $this->persistence;
        $retrieveResult = $persistence->retrieve($result->getId());
        $this->assertEquals($title, $retrieveResult->getTitle());
        $persistence->remove($result->getId());
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
        $cardIteractor = new Card();

        $requestAdd->setTitle('Kill Bill');
        $addResult = $cardIteractor->add($requestAdd);

        $requestUpdate->setId($addResult->getId())
            ->setTitle('Kill Adama');

        $updateResult = $cardIteractor->update($requestUpdate);

        $this->assertEquals($addResult->getId(), $updateResult->getId());
        $this->assertEquals($requestUpdate->getTitle(), $updateResult->getTitle());
        $this->assertTrue($updateResult->getBoolean());
    }

    public function testGet()
    {
        $requestAdd = new Add();
        $requestGet = new Get();
        $cardInteractor = new Card();

        $requestAdd->setTitle('store this please Mr. Pericles');
        $addResult = $cardInteractor->add($requestAdd);

        $requestGet->setId($addResult->getId());

        $getResult = $cardInteractor->get($requestGet);
        $this->assertTrue($getResult->getBoolean());
        $this->assertEquals($getResult->getId(), $addResult->getId());
        $this->assertEquals($getResult->getTitle(), $requestAdd->getTitle());
        $this->assertEquals($getResult->getStatus(), 1);
        $this->persistence->remove($addResult->getId());
    }

    protected function setUp()
    {
        $this->persistence = new CardPersistence();
    }
}
