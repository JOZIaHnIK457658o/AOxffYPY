<?php
// 代码生成时间: 2025-09-18 05:36:41
 * @license    MIT License (MIT)
 * @version    1.0.0
 * @link       https://yourwebsite.com
 */

// Ensure the autoloader is included for Zend Framework components
require_once 'vendor/autoload.php';

use Zend\File\SplPriorityQueue;
use Zend\ProgressBar\ProgressBar;
use Zend\ProgressBar\Adapter\JsPush;

class FileSyncTool
{
    protected $sourceDirectory;
    protected $targetDirectory;
    protected $filesToSync;
    protected $filesToBackup;

    public function __construct($sourceDirectory, $targetDirectory)
    {
        // Initialize the source and target directories
        $this->sourceDirectory = $sourceDirectory;
        $this->targetDirectory = $targetDirectory;
    }

    /**
     * Synchronize files from source to target directory
     */
    public function syncFiles()
    {
        // Create a SplPriorityQueue to hold the files to sync
        $this->filesToSync = new SplPriorityQueue();

        // Populate the queue with files from the source directory
        $this->populateQueue($this->sourceDirectory, $this->filesToSync);

        // Sync the files
        foreach ($this->filesToSync as $file) {
            $sourcePath = $file->getPathname();
            $targetPath = str_replace($this->sourceDirectory, $this->targetDirectory, $sourcePath);

            // Check if the file needs to be copied or if it's already in sync
            if (!file_exists($targetPath) || md5_file($sourcePath) != md5_file($targetPath)) {
                if (!copy($sourcePath, $targetPath)) {
                    throw new Exception("Failed to sync file: {$sourcePath} to {$targetPath}");
                }
            }
        }
    }

    /**
     * Backup files from source to target directory
     */
    public function backupFiles()
    {
        // Create a SplPriorityQueue to hold the files to backup
        $this->filesToBackup = new SplPriorityQueue();

        // Populate the queue with files from the source directory
        $this->populateQueue($this->sourceDirectory, $this->filesToBackup);

        // Backup the files
        foreach ($this->filesToBackup as $file) {
            $sourcePath = $file->getPathname();
            $targetPath = str_replace($this->sourceDirectory, $this->targetDirectory . "/backup", $sourcePath);

            // Check if the file needs to be copied
            if (!file_exists($targetPath)) {
                if (!copy($sourcePath, $targetPath)) {
                    throw new Exception("Failed to backup file: {$sourcePath} to {$targetPath}");
                }
            }
        }
    }

    /**
     * Populate the SplPriorityQueue with files from the directory
     *
     * @param string $directory
     * @param SplPriorityQueue $queue
     */
    protected function populateQueue($directory, $queue)
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($iterator as $file) {
            if (!$file->isDir()) {
                $queue->insert($file, $file->getMTime()); // priority by modification time
            }
        }
    }
}

// Example usage
try {
    $syncTool = new FileSyncTool("/path/to/source", "/path/to/target");
    $syncTool->syncFiles();
    $syncTool->backupFiles();
    echo "Files synchronized and backed up successfully.
";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
