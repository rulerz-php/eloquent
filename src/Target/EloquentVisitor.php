<?php

declare(strict_types=1);

namespace RulerZ\Eloquent\Target;

use RulerZ\Compiler\Context;
use RulerZ\Target\GenericSqlVisitor;
use RulerZ\Target\Operators\Definitions as OperatorsDefinitions;

class EloquentVisitor extends GenericSqlVisitor
{
    /**
     * Allow eloquent builder as query.
     *
     * @var bool
     */
    protected $allowEloquentBuilderAsQuery = false;

    public function __construct(Context $context, OperatorsDefinitions $operators, $allowStarOperator = true, $allowEloquentBuilderAsQuery = false)
    {
        parent::__construct($context, $operators, $allowStarOperator);

        $this->allowEloquentBuilderAsQuery = (bool) $allowEloquentBuilderAsQuery;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompilationData(): array
    {
        return [
            'allowEloquentBuilderAsQuery ' => $this->allowEloquentBuilderAsQuery,
        ];
    }
}
