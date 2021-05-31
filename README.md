# wsdl2phpgenerator-cli

*Work in progress!*

[![Build Status](https://travis-ci.org/wsdl2phpgenerator/wsdl2phpgenerator-cli.svg?branch=3.x)](https://travis-ci.org/wsdl2phpgenerator/wsdl2phpgenerator-cli)
[![Code Coverage](https://scrutinizer-ci.com/g/wsdl2phpgenerator/wsdl2phpgenerator-cli/badges/coverage.png?b=3.x)](https://scrutinizer-ci.com/g/wsdl2phpgenerator/wsdl2phpgenerator-cli/?branch=3.x)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/wsdl2phpgenerator/wsdl2phpgenerator-cli/badges/quality-score.png?b=3.x)](https://scrutinizer-ci.com/g/wsdl2phpgenerator/wsdl2phpgenerator-cli/?branch=3.x)

Command line application wrapper for the [wsdl2phpgenerator](https://github.com/wsdl2phpgenerator/wsdl2phpgenerator) library. Takes a WSDL file and outputs PHP class files ready to use.

## Installation

Use the phar version or install the wsdl2phpgenerator-cli as dev-dependency to your project

    composer require wsdl2phpgenerator/wsdl2phpgenerator-cli --dev

## Usage

When installed with composer use:

    vendor/bin/wsdl2php -i input.wsdl -o tmp/my/directory/wsdl

or

    vendor/bin/wsdl2php -i "http://www.webservicex.net/CurrencyConvertor.asmx?WSDL" -o tmp/phub -ns=My\\NameSpace\\Entity --soapClientClass=\\My\\NameSpace\\SoapClient


To use the phar version of wsdl2phpgenerator follow these steps:

1. Download [wsdl2phpgenerator-3.4.0.phar](https://github.com/wsdl2phpgenerator/wsdl2phpgenerator-cli/releases/download/3.4.0/wsdl2phpgenerator-3.4.0.phar)
1. Run `php wsdl2phpgenerator-3.4.0.phar -i input.wsdl -o tmp/my/directory/wsdl`

The directory is created if possible.

## Contributors
See [contributors](https://github.com/wsdl2phpgenerator/wsdl2phpgenerator-cli/graphs/contributors).  
Pull requests are very welcome. Please read [our guidelines for contributing](https://github.com/wsdl2phpgenerator-cli/wsdl2phpgenerator/blob/master/CONTRIBUTING.md).

## Versioning

This project mirrors [the versioning of the wsdl2phpgenerator library](https://github.com/wsdl2phpgenerator/wsdl2phpgenerator#versioning). A new release of the library will incur a new release of the CLI app with a similar name.

## Licence

Uses the [MIT licence](http://www.opensource.org/licenses/mit-license.php).

## todo
- tag dev-master as 2.5.5
- edit readme old version hint
- edit readme for phar usage and composer usage
- phpcs
