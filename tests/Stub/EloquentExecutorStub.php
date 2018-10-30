<?php

namespace Tests\RulerZ\Stub;

use RulerZ\Eloquent\Executor\FilterTrait;

class EloquentExecutorStub
{
    public static $executeReturn;

    private $allowEloquentBuilderAsQuery = false;

    use FilterTrait;

    public function execute($target, array $operators, array $parameters)
    {
        return self::$executeReturn;
    }
}
