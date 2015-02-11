<?php
/**
 * @package Wsdl2PhpGenerator
 */
use Wsdl2PhpGenerator\Console\Application;
use Wsdl2PhpGenerator\Console\GenerateCommand;
use Wsdl2PhpGenerator\Generator;

foreach (array(__DIR__ . '/../../autoload.php', __DIR__ . '/vendor/autoload.php') as $file) {
    if (file_exists($file)) {
        define('WSDL2PHP_COMPOSER_INSTALL', $file);
        break;
    }
}

if (!defined('WSDL2PHP_COMPOSER_INSTALL')) {
    die(
        'You need to set up the project dependencies using the following commands:' . PHP_EOL .
        'wget http://getcomposer.org/composer.phar' . PHP_EOL .
        'php composer.phar install' . PHP_EOL
    );
}

require WSDL2PHP_COMPOSER_INSTALL;

$app = new Application('wsdl2php', '3.x');
$command = new GenerateCommand();
$command->setGenerator(new Generator());
$app->add($command);
$app->run();
