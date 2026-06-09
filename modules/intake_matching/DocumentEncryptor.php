<?php
// modules/intake_matching/DocumentEncryptor.php

class DocumentEncryptor
{
    private string $encryptionKey;
    private string $cipherMethod = 'aes-256-cbc';

    public function __construct(string $encryptionKey)
    {
        // In a real app, this key should be stored securely in an environment variable
        $this->encryptionKey = $encryptionKey;
    }

    /**
     * Encrypts a PDF file before saving it to the server.
     */
    public function encryptAndSave(string $tmpFilePath, string $destinationPath): bool
    {
        $fileContents = file_get_contents($tmpFilePath);

        // Generate a secure initialization vector (IV)
        $ivLength = openssl_cipher_iv_length($this->cipherMethod);
        $iv = openssl_random_pseudo_bytes($ivLength);

        // Encrypt the PDF data
        $encryptedData = openssl_encrypt($fileContents, $this->cipherMethod, $this->encryptionKey, 0, $iv);

        // Prepend the IV to the encrypted data so we can use it for decryption later
        $finalData = base64_encode($iv . $encryptedData);

        // Save the encrypted string to the destination path
        return file_put_contents($destinationPath, $finalData) !== false;
    }

    /**
     * Decrypts a stored file back into a readable PDF.
     */
    public function decryptFile(string $encryptedFilePath): ?string
    {
        $encryptedData = file_get_contents($encryptedFilePath);
        if (!$encryptedData) return null;

        $decodedData = base64_decode($encryptedData);
        $ivLength = openssl_cipher_iv_length($this->cipherMethod);

        // Extract the IV and the actual encrypted content
        $iv = substr($decodedData, 0, $ivLength);
        $cipherText = substr($decodedData, $ivLength);

        // Decrypt and return the raw PDF bytes
        return openssl_decrypt($cipherText, $this->cipherMethod, $this->encryptionKey, 0, $iv);
    }
}
