<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class StrongPassword implements Rule
{
    protected $message;
    protected $minLength = 8;
    protected $checkCommonPatterns = true;
    protected $checkUserData = true;
    protected $userData = [];
    protected $commonPasswords = [
        '123456', '123456789', 'qwerty', 'password', '111111', '12345678',
        'abc123', '1234567', 'password1', '12345', '1234567890', 'admin',
        'welcome', 'admin123', 'admin@123', '123123', 'test', 'test123',
        '123', 'demo', 'pass123', 'pass@123', '654321', 'qwertyuiop'
    ];

    /**
     * Create a new rule instance.
     *
     * @param array $userData User's personal data to check against
     * @return void
     */
    public function __construct(array $userData = [])
    {
        $this->userData = $userData;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Check minimum length
        if (strlen($value) < $this->minLength) {
            $this->message = "Password must be at least {$this->minLength} characters.";
            return false;
        }

        // Check for uppercase, lowercase, number, and special character
        if (!preg_match('/[A-Z]/', $value)) {
            $this->message = 'Password must contain at least one uppercase letter.';
            return false;
        }

        if (!preg_match('/[a-z]/', $value)) {
            $this->message = 'Password must contain at least one lowercase letter.';
            return false;
        }

        if (!preg_match('/[0-9]/', $value)) {
            $this->message = 'Password must contain at least one number.';
            return false;
        }

        if (!preg_match('/[^A-Za-z0-9]/', $value)) {
            $this->message = 'Password must contain at least one special character.';
            return false;
        }

        // Check for repeating characters (more than 3 of the same character in a row)
        if (preg_match('/(.)\1{3,}/', $value)) {
            $this->message = 'Password cannot contain repeated sequences of the same character.';
            return false;
        }

        // Check for sequential characters (like '1234', 'abcd')
        if (preg_match('/(?:012345|123456|234567|345678|456789|567890|abcdef|bcdefg|cdefgh|defghi|efghij|fghijk|ghijkl|hijklm|ijklmn|jklmno|klmnop|lmnopq|mnopqr|nopqrs|opqrst|pqrstu|qrstuv|rstuvw|stuvwx|tuvwxy|uvwxyz|qwerty|asdfgh|zxcvbn)/', strtolower($value))) {
            $this->message = 'Password cannot contain sequential character patterns.';
            return false;
        }

        // Check against common passwords
        if ($this->checkCommonPatterns) {
            foreach ($this->commonPasswords as $common) {
                if (stripos($value, $common) !== false) {
                    $this->message = 'Password contains a common pattern that is too easily guessed.';
                    return false;
                }
            }
        }

        // Check against user data if present
        if ($this->checkUserData && !empty($this->userData)) {
            foreach ($this->userData as $data) {
                if (empty($data) || !is_string($data) || strlen($data) < 3) {
                    continue;
                }
                
                $data = strtolower($data);
                $lowercaseValue = strtolower($value);
                
                // Check if password contains user data
                if (strlen($data) > 3 && stripos($lowercaseValue, $data) !== false) {
                    $this->message = 'Password cannot contain personal information.';
                    return false;
                }
                
                // Check for reverse user data
                $reverseData = strrev($data);
                if (strlen($data) > 3 && stripos($lowercaseValue, $reverseData) !== false) {
                    $this->message = 'Password cannot contain reversed personal information.';
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message ?? 'The password does not meet security requirements.';
    }
}