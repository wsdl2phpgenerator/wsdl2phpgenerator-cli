# wsdl2phpgenerator-cli 

*Work in progress!* 

[![Build Status](https://travis-ci.org/wsdl2phpgenerator/wsdl2phpgenerator-cli.svg?branch=3.x)](https://travis-ci.org/wsdl2phpgenerator/wsdl2phpgenerator-cli)
[![Code Coverage](https://scrutinizer-ci.com/g/wsdl2phpgenerator/wsdl2phpgenerator-cli/badges/coverage.png?b=3.x)](https://scrutinizer-ci.com/g/wsdl2phpgenerator/wsdl2phpgenerator-cli/?branch=3.x)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/wsdl2phpgenerator/wsdl2phpgenerator-cli/badges/quality-score.png?b=3.x)](https://scrutinizer-ci.com/g/wsdl2phpgenerator/wsdl2phpgenerator-cli/?branch=3.x)
[![Dependency Status](https://www.versioneye.com/user/projects/53c4ab1b617ed40453000073/badge.svg)](https://www.versioneye.com/user/projects/53c4ab1b617ed40453000073)

Command line application wrapper for the [wsdl2phpgenerator](https://github.com/wsdl2phpgenerator/wsdl2phpgenerator) library. Takes a WSDL file and outputs PHP class files ready to use.

Uses the [MIT licence](http://www.opensource.org/licenses/mit-license.php).

## Contributors
Originally developed by [@walle](https://github.com/walle) and includes bugfixes and improvements from [@vakopian](https://github.com/vakopian), [@statikbe](https://github.com/statikbe/),
[@ecolinet](https://github.com/ecolinet), [@nuth](https://github.com/nuth/), [@chriskl](https://github.com/chriskl/), [@RSully](https://github.com/RSully/), [@jrbasso](https://github.com/jrbasso/),
[@dypa](https://github.com/dypa/), [@Lafriks](https://github.com/Lafriks/) and [@kasperg](https://github.com/kasperg/).

Pull requests are very welcome. Please read [our guidelines for contributing](https://github.com/wsdl2phpgenerator/wsdl2phpgenerator/blob/master/CONTRIBUTING.md).

## Mailing list

There is a mailing list for the project at [https://groups.google.com/forum/#!forum/wsdl2phpgenerator](https://groups.google.com/forum/#!forum/wsdl2phpgenerator)

## Usage

Getting a cli version of wsdl2phpgenerator 3 is a work in progress.

To use the last version of wsdl2phpgenerator 2 follow these steps:

1. Download [wsdl2phpgenerator-2.5.5.phar](https://github.com/wsdl2phpgenerator/wsdl2phpgenerator/releases/download/2.5.5/wsdl2phpgenerator-2.5.5.phar)
1. Run `php wsdl2phpgenerator-2.5.5.phar -i input.wsdl -o tmp/my/directory/wsdl`

The directory is created if possible.


## Versioning

This project mirrors [the versioning of the wsdl2phpgenerator library](https://github.com/wsdl2phpgenerator/wsdl2phpgenerator#versioning). A new release of the library will incur a new release of the CLI app with a similar name.
