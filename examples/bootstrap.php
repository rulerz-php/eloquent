<?php

declare(strict_types=1);

use PommProject\Foundation\Pomm;
use RulerZ\RulerZ;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

$pomm = new Pomm(['test_rulerz' => [
    'dsn' => sprintf('pgsql://%s:%s@%s:%d/%s', $_ENV['POSTGRES_USER'], $_ENV['POSTGRES_PASSWD'], $_ENV['POSTGRES_HOST'], $_ENV['POSTGRES_PORT'], $_ENV['POSTGRES_DB']),
    'class:session_builder' => \PommProject\ModelManager\SessionBuilder::class,
]]);

// compiler
$compiler = new \RulerZ\Compiler\Compiler(new \RulerZ\Compiler\EvalEvaluator());

// compiled RulerZ
$rulerz = new RulerZ($compiler, [new \RulerZ\Pomm\Target\Pomm()]);

return [$pomm, $rulerz];
