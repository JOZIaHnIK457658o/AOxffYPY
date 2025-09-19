<?php
// 代码生成时间: 2025-09-20 01:00:23
class JsonConverter {

    /**
     * Converts JSON data to a PHP array.
     *
     * @param string $jsonData The JSON data to be converted.
     * @return array|false The converted PHP array or false on error.
     */
    public function jsonToArray($jsonData) {
        try {
            // Decode the JSON data and return the result
            return json_decode($jsonData, true);
        } catch (Exception $e) {
            // Handle any errors that occur during decoding
            error_log('Error decoding JSON: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Converts a PHP array to JSON data.
     *
     * @param array $phpArray The PHP array to be converted.
     * @return string|false The converted JSON data or false on error.
     */
    public function arrayToJson($phpArray) {
        try {
            // Encode the PHP array and return the result
            return json_encode($phpArray);
        } catch (Exception $e) {
            // Handle any errors that occur during encoding
            error_log('Error encoding JSON: ' . $e->getMessage());
            return false;
        }
    }
}

/**
 * Example usage of the JsonConverter class.
 */
try {
    // Create an instance of the JsonConverter class
    $converter = new JsonConverter();

    // Example JSON data
    $jsonData = '{"name":"John", "age":30}';

    // Convert JSON to PHP array
    $phpArray = $converter->jsonToArray($jsonData);
    if ($phpArray !== false) {
        echo "PHP array: ";
        print_r($phpArray);
    } else {
        echo "Failed to convert JSON to PHP array.";
    }

    // Convert PHP array back to JSON
    $jsonResult = $converter->arrayToJson($phpArray);
    if ($jsonResult !== false) {
        echo "JSON result: " . $jsonResult;
    } else {
        echo "Failed to convert PHP array to JSON.";
    }
} catch (Exception $e) {
    // Catch any unexpected errors
    error_log('Unexpected error: ' . $e->getMessage());
}