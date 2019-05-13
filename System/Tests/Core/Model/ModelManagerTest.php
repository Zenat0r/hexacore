<?php

namespace Hexacore\Tests\Core\Model;

use Hexacore\Core\Model\Manager\ModelManager;
use Hexacore\Tests\Mocks\Model\FakeModelMock;
use Hexacore\Tests\Mocks\Model\ModelMock;
use Hexacore\Tests\Mocks\Model\QueryBuilderMock;
use PHPUnit\Framework\TestCase;

/**
 * Class ModelManagerTest
 * @package Hexacore\Tests\Core\Model
 * @covers \Hexacore\Core\Model\Manager\ModelManager
 */
class ModelManagerTest extends TestCase
{
    public function testDelete()
    {
        $qb = new QueryBuilderMock();
        $mm = new ModelManager($qb);

        $mm->delete(new ModelMock(1, "value"));

        $this->assertTrue($qb->delete);
    }

    public function testDeleteWithException()
    {
        $mm = new ModelManager(new QueryBuilderMock());

        $this->expectException(\Exception::class);

        $mm->delete(new FakeModelMock());
    }

    public function testPersistFakeModelWithException()
    {
        $mm = new ModelManager(new QueryBuilderMock());

        $this->expectException(\Exception::class);

        $mm->persist(new FakeModelMock(1, "value"));
    }

    public function testPersistModel()
    {
        $qb = new QueryBuilderMock();
        $mm = new ModelManager($qb);

        $mm->persist(new ModelMock(null, "value"));

        $this->assertTrue($qb->create);
    }

    public function testPersistUpdate()
    {
        $qb = new QueryBuilderMock();
        $mm = new ModelManager($qb);

        $mm->persist(new ModelMock(1, "value"));

        $this->assertTrue($qb->update);
    }

    public function testPersistNotId()
    {
        $mm = new ModelManager(new QueryBuilderMock());

        $this->expectException(\Exception::class);

        $mm->persist(new \Hexacore\Tests\Mocks\Model\FakeModelWithoutIdMock(1, "value"));
    }

    public function test__construct()
    {
        $this->assertInstanceOf(ModelManager::class, new ModelManager(new QueryBuilderMock()));
    }
}
