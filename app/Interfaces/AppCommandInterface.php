<?php

namespace App\Interfaces;

use Spatie\Valuestore\Valuestore;

class AppCommandInterface
{
    private $config;
    private $configPath;

    public function __construct($config, $configPath)
    {
        $this->config = $config;
        $this->configPath = $configPath;
    }

    /**
     * Change a value in the settings.ini file.
     *
     * @param $pathToTarget
     * @param $value
     */
    public function changeSetting($pathToTarget, $value)
    {
        $target = &$this->config;

        foreach (explode('.', $pathToTarget) as $step) {
            $target = &$target[$step];
        }

        $target = $value;

        $this->regenerateConfig();
    }

    /**
     * Regenerate the app config file.
     */
    public function regenerateConfig()
    {
        Valuestore::make($this->configPath, $this->config);
    }
}
