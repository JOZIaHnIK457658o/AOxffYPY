<?php
// 代码生成时间: 2025-09-23 22:12:38
// Ensure the Phar extension is enabled
if (!extension_loaded('phar')) {
    die('\''phar\'' extension is not enabled.');
}

class UnzipTool {
    /*
     * Unzips a given archive file to a specified directory.
     *
     * @param string $archivePath Path to the archive file.
     * @param string $destinationPath Path to the destination directory.
     * @return bool Returns true on success, false on failure.
     */
    public function unzip($archivePath, $destinationPath) {
        // Check if the archive file exists
        if (!file_exists($archivePath)) {
            // Log error and return false
            error_log('Archive file does not exist: ' . $archivePath);
            return false;
        }

        // Create the destination directory if it does not exist
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Try to open the archive file
        try {
            // Use PharData to handle different types of archives
            $phar = new PharData($archivePath);
            $phar->extractTo($destinationPath, null, true);
            return true;
        } catch (Exception $e) {
            // Log exception and return false
            error_log('Unzip failed: ' . $e->getMessage());
            return false;
        }
    }
}

// Example usage
/**
 * Usage of UnzipTool class to unzip a file.
 */
try {
    $unzipTool = new UnzipTool();
    $archivePath = 'path/to/your/archive.zip';
    $destinationPath = 'path/to/your/destination/directory';
    if ($unzipTool->unzip($archivePath, $destinationPath)) {
        echo 'Unzipping successful.';
    } else {
        echo 'Unzipping failed.';
    }
} catch (Exception $e) {
    echo 'An error occurred: ' . $e->getMessage();
}

/*
 * Note: This example assumes that the archive is a ZIP file.
 * For other archive types, ensure that the corresponding PHP extensions are enabled.
 */
