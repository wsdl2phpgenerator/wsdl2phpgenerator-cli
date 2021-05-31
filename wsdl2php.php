<?php
/**
 * @package Wsdl2PhpGenerator
 */
use Wsdl2PhpGenerator\Console\Application;
use Wsdl2PhpGenerator\Console\GenerateCommand;
use Wsdl2PhpGenerator\Generator;

require 'vendor/autoload.php';

$app = new Application('wsdl2php', '3.4.0');
$command = new GenerateCommand();
$command->setGenerator(new Generator());
$app->add($command);
$app->run();
