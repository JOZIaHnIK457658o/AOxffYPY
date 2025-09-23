<?php
// 代码生成时间: 2025-09-24 01:18:55
class PasswordTool {

    /**
     * Encrypts a password using a specified encryption method.
     *
     * @param string $password The password to be encrypted.
     * @param string $encryptionMethod The encryption method to use.
     * @return string The encrypted password.
     * @throws Exception If the encryption method is not supported.
     */
    public function encryptPassword($password, $encryptionMethod) {
        if ($encryptionMethod === 'bcrypt') {
            // Use PHP's built-in password_hash function for bcrypt encryption
            return password_hash($password, PASSWORD_BCRYPT);
        } elseif ($encryptionMethod === 'sha256') {
            // Use hash function for SHA-256 encryption
            return hash('sha256', $password);
        } else {
            // Throw an exception if the encryption method is not supported
            throw new Exception("Unsupported encryption method: {$encryptionMethod}");
        }
    }

    /**
     * Decrypts an encrypted password.
     *
     * @param string $encryptedPassword The encrypted password to be decrypted.
     * @param string $encryptionMethod The encryption method used for encryption.
     * @param string $password The original password to check against.
     * @return bool True if the decryption is successful, otherwise false.
     * @throws Exception If the encryption method is not supported.
     */
    public function decryptPassword($encryptedPassword, $encryptionMethod, $password) {
        if ($encryptionMethod === 'bcrypt') {
            // Use PHP's built-in password_verify function for bcrypt decryption
            return password_verify($password, $encryptedPassword);
        } elseif ($encryptionMethod === 'sha256') {
            // For SHA-256, we can only check if the hash matches, not decrypt
            return hash('sha256', $password) === $encryptedPassword;
        } else {
            // Throw an exception if the encryption method is not supported
            throw new Exception("Unsupported encryption method: {$encryptionMethod}");
        }
    }
}

// Usage example
try {
    $passwordTool = new PasswordTool();
    $originalPassword = 'mySecretPassword';
    $encryptionMethod = 'bcrypt';
    $encryptedPassword = $passwordTool->encryptPassword($originalPassword, $encryptionMethod);
    echo "Encrypted Password: " . $encryptedPassword . "
";

    // Attempt to decrypt the password
    $isDecrypted = $passwordTool->decryptPassword($encryptedPassword, $encryptionMethod, $originalPassword);
    echo "Decryption Successful: " . ($isDecrypted ? 'Yes' : 'No') . "
";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "
";
}
