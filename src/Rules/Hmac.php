<?php

namespace DavidPeach\LaravelHmacValidationRule\Rules;

use Illuminate\Contracts\Validation\Rule;

class Hmac implements Rule
{
    public function __construct(
        private array $dataToHash
    ){}

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $correctHash = hash_hmac(
            'sha256',
            json_encode($this->dataToHash),
            config('hmac_validation.secret')
        );

        return $value === $correctHash;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        $hashKeys = array_keys($this->dataToHash);
        $keysString = implode(', ', $hashKeys);

        return vsprintf(
            'Please provide a valid hmac using key value pairs for the fields: %s.',
            [
                $keysString,
            ],
        );
    }
}
