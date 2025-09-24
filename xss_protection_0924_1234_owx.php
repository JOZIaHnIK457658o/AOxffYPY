<?php
// 代码生成时间: 2025-09-24 12:34:20
 * It is designed to be easily extendable and maintainable.
 */
class XssProtection {

    /**
     * Sanitize user input to prevent XSS attacks.
     *
     * @param string $input The user input to sanitize.
     * @return string The sanitized input.
     */
    public function sanitizeInput($input) {
        // Remove all illegal characters from the input
        $sanitizedInput = filter_var($input, FILTER_SANITIZE_STRING);

        // Strip all HTML tags to prevent script execution
        $sanitizedInput = strip_tags($sanitizedInput);

        // Additional sanitization can be added here as needed

        return $sanitizedInput;
    }

    /**
     * Escape output to prevent XSS attacks.
     *
     * @param string $output The output to escape.
     * @return string The escaped output.
     */
    public function escapeOutput($output) {
        // Escape special characters to prevent script execution
        $escapedOutput = htmlspecialchars($output, ENT_QUOTES, 'UTF-8');

        return $escapedOutput;
    }
}

// Usage example
try {
    $xssProtection = new XssProtection();

    // Sanitize user input
    $userInput = "<script>alert('XSS')</script>";
    $sanitizedInput = $xssProtection->sanitizeInput($userInput);

    // Escape output
    $userOutput = "<script>alert('XSS')</script>";
    $escapedOutput = $xssProtection->escapeOutput($userOutput);

    echo "Sanitized Input: " . $sanitizedInput;
    echo "Escaped Output: " . $escapedOutput;

} catch (Exception $e) {
    // Handle errors
    echo "Error: " . $e->getMessage();
}
