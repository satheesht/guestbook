<?php
namespace Detectify\Traits;

use Detectify\Exceptions\InvalidConfigException;

/**
 * Trait Config
 */
Trait Config{

    protected $config;

    /**
     * Reads config file if it hasn't read before
     * @throws InvalidConfigException
     */
    private function loadConfig()
    {
        $configFilePath = getenv("CONFIG_FILE_PATH");
        if(empty($this->config)) {
            if (file_exists($configFilePath) && is_readable($configFilePath) || is_file($configFilePath)) {
                $configString = file_get_contents($configFilePath);
                $this->config = json_decode($configString);
                if ($this->config === NULL) {
                    $this->failConfig();
                }
            }else{
                $this->failConfig();
            }
        }
    }

    /**
     * @return mixed
     * @throws InvalidConfigException
     */
    private function getRoutes(){
        $this->loadConfig();
        return $this->config->routes;
    }

    /**
     * @throws InvalidConfigException
     */
    private function failConfig(){
        throw new InvalidConfigException();
    }
}