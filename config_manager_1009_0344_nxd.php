<?php
// 代码生成时间: 2025-10-09 03:44:32
class ConfigManager {

    private $configPath;
    private $configData = [];

    /**
     * Constructor to initialize the configuration path
     *
     * @param string $configPath The path to the configuration directory
     */
    public function __construct($configPath) {
        $this->configPath = $configPath;
        $this->loadConfigFiles();
    }

    /**
     * Load configuration files from the specified directory
     */
    private function loadConfigFiles() {
        if (!is_dir($this->configPath)) {
            // Handle error when configuration directory does not exist
            throw new InvalidArgumentException('Configuration directory does not exist.');
        }

        $files = scandir($this->configPath);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $configData = include $this->configPath . '/' . $file;
                $this->configData[$file] = $configData;
            }
        }
    }

    /**
     * Get a configuration value by key
     *
     * @param string $key The key to look up in the configuration
     * @return mixed The value associated with the key
     */
    public function get($key) {
        // Split the key by dot to allow nested configuration access
        list($filename, $keyPath) = explode('.', $key, 2);
        if (isset($this->configData[$filename]) && is_array($this->configData[$filename])) {
            return $this->getValueByPath($this->configData[$filename], $keyPath);
        }

        // Handle error when key does not exist
        throw new InvalidArgumentException('Configuration key does not exist.');
    }

    /**
     * Recursively get a value by a dot-separated key path
     *
     * @param array $array The array to search in
     * @param string $keyPath The dot-separated key path
     * @return mixed The value associated with the key path
     */
    private function getValueByPath(array $array, $keyPath) {
        $currentKey = explode('.', $keyPath, 2)[0];
        if (isset($array[$currentKey])) {
            if (count(explode('.', $keyPath, 2)) > 1) {
                return $this->getValueByPath($array[$currentKey], substr($keyPath, strpos($keyPath, '.') + 1));
            } else {
                return $array[$currentKey];
            }
        } else {
            return null;
        }
    }

    /**
     * Set a configuration value by key
     *
     * @param string $key The key to set
     * @param mixed $value The value to set
     */
    public function set($key, $value) {
        // Split the key by dot to allow nested configuration access
        list($filename, $keyPath) = explode('.', $key, 2);
        if (isset($this->configData[$filename]) && is_array($this->configData[$filename])) {
            $this->setValueByPath($this->configData[$filename], $keyPath, $value);
        } else {
            // Handle error when key does not exist
            throw new InvalidArgumentException('Configuration key does not exist.');
        }
    }

    /**
     * Recursively set a value by a dot-separated key path
     *
     * @param array $array The array to set the value in
     * @param string $keyPath The dot-separated key path
     * @param mixed $value The value to set
     */
    private function setValueByPath(array &$array, $keyPath, $value) {
        $currentKey = explode('.', $keyPath, 2)[0];
        if (count(explode('.', $keyPath, 2)) > 1) {
            if (!isset($array[$currentKey]) || !is_array($array[$currentKey])) {
                $array[$currentKey] = [];
            }
            $this->setValueByPath($array[$currentKey], substr($keyPath, strpos($keyPath, '.') + 1), $value);
        } else {
            $array[$currentKey] = $value;
        }
    }

    /**
     * Save the configuration data to files
     */
    public function saveConfigFiles() {
        foreach ($this->configData as $filename => $configData) {
            $filePath = $this->configPath . '/' . $filename;
            file_put_contents($filePath, '<?php return ' . var_export($configData, true) . ';');
        }
    }
}
