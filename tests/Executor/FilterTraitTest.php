<?php

declare(strict_types=1);

namespace Tests\RulerZ\Executor;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection as EloquentCollection;

use PHPUnit\Framework\TestCase;
use RulerZ\Context\ExecutionContext;
use Tests\RulerZ\Stub\EloquentExecutorStub;

class FilterTraitTest extends TestCase
{
    private $executor;

    public function setUp()
    {
        $this->executor = new EloquentExecutorStub();
    }

    public function testItCanApplyAFilterOnATarget()
    {
        $queryBuilder = $this->createMock(QueryBuilder::class);
        $parameters = [];
        $sql = 'sql query';

        $queryBuilder->expects($this->never())->method('get');

        $queryBuilder->expects($this->once())
            ->method('whereRaw')
            ->with($sql, $parameters);

        EloquentExecutorStub::$executeReturn = $sql;

        $modifiedQb = $this->executor->applyFilter($queryBuilder, $parameters, $operators = [], new ExecutionContext());

        $this->assertSame($queryBuilder, $modifiedQb);
    }

    public function testItHandlesQueryBuilders()
    {
        $queryBuilder = $this->createMock(QueryBuilder::class);

        $results = new EloquentCollection(['result']);
        $parameters = [];
        $sql = 'sql query';

        $queryBuilder->expects($this->once())
            ->method('get')
            ->willReturn($results);

        $queryBuilder->expects($this->once())
            ->method('whereRaw')
            ->with($sql, $parameters);

        EloquentExecutorStub::$executeReturn = $sql;

        $filteredResults = $this->executor->filter($queryBuilder, $parameters, $operators = [], new ExecutionContext());

        $this->assertInstanceOf(\Traversable::class, $filteredResults, 'Executors always return traversable objects');
        $this->assertSame($results, $filteredResults);
    }

    public function testItHandlesEloquentBuilders()
    {
        $eloquentBuilder = $this->createMock(EloquentBuilder::class);
        $builder = $this->createMock(QueryBuilder::class);

        $results = new EloquentCollection(['result']);
        $parameters = [];
        $sql = 'sql query';

        $eloquentBuilder->expects($this->once())
            ->method('getQuery')
            ->willReturn($builder);

        $builder->expects($this->once())
            ->method('get')
            ->willReturn($results);

        $builder->expects($this->once())
            ->method('whereRaw')
            ->with($sql, $parameters);

        EloquentExecutorStub::$executeReturn = $sql;

        $filteredResults = $this->executor->filter($eloquentBuilder, $parameters, $operators = [], new ExecutionContext());

        $this->assertInstanceOf(\Traversable::class, $filteredResults, 'Executors always return traversable objects');
        $this->assertSame($results, $filteredResults);
    }
}
