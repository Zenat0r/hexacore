<?php

namespace Hexacore\Tests\Core\Model;

use Hexacore\Core\Model\Repository\ModelRepository;
use Hexacore\Tests\Mocks\Model\ModelMock;
use Hexacore\Tests\Mocks\Model\QueryBuilderMock;
use PHPUnit\Framework\TestCase;

class ModelRepositoryTest extends TestCase
{
    /**
     * @var ModelRepository
     */
    private $modelRepository;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->modelRepository = new ModelRepository(new QueryBuilderMock());
    }

    /**
     * @covers \Hexacore\Core\Model\Repository\ModelRepository::__construct
     */
    public function test__construct()
    {
        $this->assertInstanceOf(ModelRepository::class, new ModelRepository(new QueryBuilderMock()));
    }

    /**
     * @throws \Exception
     * @covers \Hexacore\Core\Model\Repository\ModelRepository
     */
    public function testFindAll()
    {
        $this->modelRepository->setModel(ModelMock::class);

        $expected = [new ModelMock(1, "john"), new ModelMock(2, "wick")];

        $this->assertEquals($expected, $this->modelRepository->findAll());
    }

    /**
     * @covers \Hexacore\Core\Model\Repository\ModelRepository
     */
    public function testSetModel()
    {
        $this->assertInstanceOf(ModelRepository::class, $this->modelRepository->setModel(ModelMock::class));
    }

    /**
     * @covers \Hexacore\Core\Model\Repository\ModelRepository
     */
    public function testFindById()
    {
        $this->modelRepository->setModel(ModelMock::class);

        $expected = new ModelMock(2, "wick");

        $this->assertEquals($expected, $this->modelRepository->findById(2));
    }
}
