<?php

namespace Expressly\ServiceProvider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * reimplementation of:
 * https://github.com/deralex/YamlConfigServiceProvider/blob/master/src/DerAlex/Silex/YamlConfigServiceProvider.php
 * @codeCoverageIgnore
 */
class YamlConfigServiceProvider implements ServiceProviderInterface
{
    protected $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function register(Container $container)
    {
        $config = Yaml::parse(file_get_contents($this->file));
        if (is_array($config)) {
            $this->importSearch($config, $container);
            if (isset($container['config']) && is_array($container['config'])) {
                $container['config'] = array_replace_recursive($container['config'], $config);
            } else {
                $container['config'] = $config;
            }
        }
    }

    public function importSearch(&$config, $container)
    {
        foreach ($config as $key => $value) {
            if ($key == 'imports') {
                foreach ($value as $resource) {
                    $base_dir = str_replace(basename($this->file), '', $this->file);
                    $new_config = new YamlConfigServiceProvider($base_dir . $resource['resource']);
                    $new_config->register($container);
                }
                unset($config['imports']);
            }
        }
    }

    public function getConfigFile()
    {
        return $this->file;
    }
}