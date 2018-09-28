<?php

declare(strict_types=1);

use Behat\Behat\Context\Context as BehatContext;
use Illuminate\Database\Capsule\Manager as Capsule;
use Entity\Eloquent\Player;
use RulerZ\Test\BaseContext;

class Context extends BaseContext implements BehatContext
{
    public function initialize()
    {
        $capsule = new Capsule();

        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => __DIR__.'/../../examples/rulerz.db', // meh.
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    /**
     * {@inheritdoc}
     */
    protected function getCompilationTarget(): \RulerZ\Compiler\CompilationTarget
    {
        return new \RulerZ\Eloquent\Target\Eloquent();
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDataset()
    {
        return Player::query();
    }
}
