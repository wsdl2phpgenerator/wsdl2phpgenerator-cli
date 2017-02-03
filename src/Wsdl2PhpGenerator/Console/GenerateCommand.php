<?php


namespace Wsdl2PhpGenerator\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Wsdl2PhpGenerator\Config;
use Wsdl2PhpGenerator\GeneratorInterface;

/**
 * The console command which generates PHP code from a WSDL file.
 * This maps input arguments and options to a configuration and launches the generator.
 *
 * @package Wsdl2PhpGenerator\Console
 */
class GenerateCommand extends Command
{

    /**
     * The generator to be used when executing the command.
     *
     * @var GeneratorInterface
     */
    protected $generator;

    /**
     * An array of functions which map input arguments and options to configuration options.
     *
     * @var array
     */
    protected $inputConfigMapping = array();

    protected function configure()
    {
        $this
            ->setName('wsdl2phpgenerator:generate')
            ->setAliases(array('generate'))
            ->setDescription('Generate PHP classes from a WSDL file')
            // Input and output configuration is required and should thus be arguments but to retain the signature of
            // previous versions we specify them as required options for now.
            ->addConfigOption(
                'input',
                'i',
                InputOption::VALUE_REQUIRED,
                'The input wsdl file <fg=yellow>*Required</fg=yellow>',
                null,
                'inputFile'
            )
            ->addConfigOption(
                'output',
                'o',
                InputOption::VALUE_REQUIRED,
                'The output directory or file if -s is used (in that case, .php will be appened to file name) <fg=yellow>*Required</fg=yellow>',
                null,
                'outputDir'
            )

            ->addConfigOption(
                'classes',
                'c',
                InputOption::VALUE_REQUIRED,
                "A comma separated list of classnames to generate.\nIf this is used only classes that exist in the list will be generated.\nIf the service is not in this list and the -s flag is used\nthe filename will be the name of the first class that is generated",
                null,
                'classNames'
            )
            ->addConfigOption(
                'constructorNull',
                null,
                InputOption::VALUE_NONE,
                'Set the default value for constructor parameters to null',
                null,
                'constructorParamsDefaultToNull'
            )
            ->addConfigOption(
                'gzip',
                null,
                InputOption::VALUE_NONE,
                'Adds the option to compress the wsdl with gzip to the client',
                null,
                'compression'
            )
            ->addConfigOption(
                'namespace',
                'n',
                InputOption::VALUE_REQUIRED,
                'Use namespace with the name',
                null,
                'namespaceName'
            )
            ->addConfigOption(
                'noTypeConstructor',
                't',
                InputOption::VALUE_NONE,
                'If no type constructor should be generated',
                null,
                'noTypeConstructor'
            )
            ->addConfigOption(
                'sharedTypes',
                null,
                InputOption::VALUE_NONE,
                'If multiple class got the name, the first will be used, other will be ignored',
                null,
                'sharedTypes'
            )
            ->addCacheOption(
                'cacheNone',
                null,
                InputOption::VALUE_NONE,
                'Adds the option to not cache the wsdl to the client',
                null,
                'WSDL_CACHE_NONE'
            )
            ->addCacheOption(
                'cacheDisk',
                null,
                InputOption::VALUE_NONE,
                'Adds the option to cache the wsdl on disk to the client',
                null,
                'WSDL_CACHE_DISK'
            )
            ->addCacheOption(
                'cacheMemory',
                null,
                InputOption::VALUE_NONE,
                'Adds the option to cache the wsdl in memory to the client',
                null,
                'WSDL_CACHE_MEMORY'
            )
            ->addCacheOption(
                'cacheBoth',
                null,
                InputOption::VALUE_NONE,
                'Adds the option to cache the wsdl in memory and on disk to the client',
                null,
                'WSDL_CACHE_BOTH'
            );
    }

    /**
     * @param GeneratorInterface $generator The generator to be used when executing the command.
     */
    public function setGenerator(GeneratorInterface $generator)
    {
        $this->generator = $generator;
    }


    /**
     * Adds an argument where the value maps to a generator configuration.
     *
     * @param string $name The argument name
     * @param integer $mode The argument mode: InputArgument::REQUIRED or InputArgument::OPTIONAL
     * @param string $description A description text
     * @param mixed $default The default value (for InputArgument::OPTIONAL mode only)
     * @param string|callable $configMapping The name of the configuration value to map the argument value to.
     * @return GenerateCommand The current instance
     */
    protected function addConfigArgument(
        $name,
        $mode = null,
        $description = '',
        $default = null,
        $configMapping = null
    ) {
        $this->setConfigMapping($name, $configMapping);
        return $this->addArgument($name, $mode, $description, $default);
    }

    /**
     * Adds an option where the value maps to a generator configuration.
     *
     * @param string $name The option name
     * @param string $shortcut The shortcut (can be null)
     * @param integer $mode The option mode: One of the InputOption::VALUE_* constants
     * @param string $description A description text
     * @param mixed $default The default value (must be null for InputOption::VALUE_REQUIRED or InputOption::VALUE_NONE)
     * @param string|callable $configMapping The name of the configuration value to map the argument value to or an
     *  anonymous function which performs the mapping.
     * @return GenerateCommand The current instance
     */
    protected function addConfigOption(
        $name,
        $shortcut = null,
        $mode = null,
        $description = '',
        $default = null,
        $configMapping = null
    ) {
        $this->setConfigMapping($name, $configMapping);
        return $this->addOption($name, $shortcut, $mode, $description, $default);
    }

    /**
     * @param string $name
     * @param string $shortcut
     * @param integer $mode
     * @param string $description
     * @param mixed $default
     * @param string $cache
     * @return GenerateCommand
     */
    protected function addCacheOption(
        $name,
        $shortcut = null,
        $mode = null,
        $description = '',
        $default = null,
        $cache = null
    ) {
        $cacheMapping = function (Input $input, Config &$config) use ($name, $cache) {
            if ($input->getOption($name)) {
                $config->set('wsdlCache', $cache);
            }
        };
        return $this->addConfigOption($name, $shortcut, $mode, $description, $default, $cacheMapping);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Input and output options are in fact required so bail if they are not set.
        if (!$input->getOption('input') || !$input->getOption('output')) {
            throw new \RuntimeException('Not enough arguments. Please specify input and output options.');
        }

        // Initialize configuration with null values. They will be updated during mapping.
        $config = new Config(array(
            'inputFile' => null,
            'outputDir' => null
        ));

        // Map arguments to configuration
        foreach ($this->inputConfigMapping as $mapping) {
            $mapping($input, $config);
        }

        $this->generator->setLogger(new OutputLogger($output));

        // Go generate!
        $this->generator->generate($config);
    }

    /**
     * @param $name
     * @param $configMapping
     */
    protected function setConfigMapping($name, $configMapping)
    {
        if (!empty($configMapping)) {
            if (!is_callable($configMapping)) {
                $configMapping = function (InputInterface $input, Config &$config) use ($name, $configMapping) {
                    $value = false;
                    if ($input->hasArgument($name)) {
                        $value = $input->getArgument($name);
                    } elseif ($input->hasOption($name)) {
                        $value = $input->getOption($name);
                    }
                    if (!empty($value)) {
                        $config->set($configMapping, $value);
                    }
                };
            }
            $this->inputConfigMapping[] = $configMapping;
        }
    }
}
