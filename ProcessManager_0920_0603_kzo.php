<?php
// 代码生成时间: 2025-09-20 06:03:57
class ProcessManager {

    /**
     * @var array List of processes
     */
    private $processes = [];

    /**
     * Add a new process to the manager
     *
     * @param string $processName The name of the process
     * @param callable $callback The callback function to execute when running the process
     *
     * @return void
     */
    public function addProcess($processName, callable $callback) {
        if (isset($this->processes[$processName])) {
            throw new Exception("Process '{$processName}' already exists.");
        }

        $this->processes[$processName] = $callback;
    }

    /**
     * Run a specific process
     *
     * @param string $processName The name of the process to run
     *
     * @return mixed The result of the process
     * @throws Exception If the process does not exist
     */
    public function runProcess($processName) {
        if (!isset($this->processes[$processName])) {
            throw new Exception("Process '{$processName}' does not exist.");
        }

        return call_user_func($this->processes[$processName]);
    }

    /**
     * Get the list of all processes
     *
     * @return array The list of processes
     */
    public function getProcesses() {
        return array_keys($this->processes);
    }

    /**
     * Remove a process from the manager
     *
     * @param string $processName The name of the process to remove
     *
     * @return void
     * @throws Exception If the process does not exist
     */
    public function removeProcess($processName) {
        if (!isset($this->processes[$processName])) {
            throw new Exception("Process '{$processName}' does not exist.");
        }

        unset($this->processes[$processName]);
    }
}

// Example usage:
try {
    $processManager = new ProcessManager();

    // Add a new process
    $processManager->addProcess('exampleProcess', function() {
        echo "Running example process...
";
        return "Process completed";
    });

    // Run a process
    echo $processManager->runProcess('exampleProcess');

    // Get list of all processes
    print_r($processManager->getProcesses());

    // Remove a process
    $processManager->removeProcess('exampleProcess');
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
