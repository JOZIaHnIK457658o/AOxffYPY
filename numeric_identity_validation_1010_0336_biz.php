<?php
// 代码生成时间: 2025-10-10 03:36:21
class NumericIdentityValidation {

    /**
     * Validates a given numeric identity.
     *
     * @param string $identity The numeric identity to validate.
     * @return bool Returns true if the identity is valid, false otherwise.
     *
     * @throws InvalidArgumentException If the identity is not a string or is empty.
     */
    public function validateIdentity($identity) {
        // Check if the identity is a string and not empty
        if (!is_string($identity) || empty($identity)) {
            throw new InvalidArgumentException('Identity must be a non-empty string.');
        }

        // Check if the identity contains only numeric characters
        if (!ctype_digit($identity)) {
            // Log the error for debugging purposes (optional)
            // error_log('Invalid numeric identity: ' . $identity);

            // Return false if the identity is not numeric
            return false;
        }

        // Perform additional validation if necessary (e.g., length, specific format)
        // For example, check if the identity has the correct length
        if (strlen($identity) !== 10) {
            // Log the error for debugging purposes (optional)
            // error_log('Invalid numeric identity length: ' . $identity);

            return false;
        }

        // If all checks pass, return true
        return true;
    }

}

// Usage example
try {
    $validator = new NumericIdentityValidation();
    $identity = '1234567890';

    if ($validator->validateIdentity($identity)) {
        echo 'Identity is valid.';
    } else {
        echo 'Identity is invalid.';
    }
} catch (InvalidArgumentException $e) {
    echo 'Error: ' . $e->getMessage();
}
