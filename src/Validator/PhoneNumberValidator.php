<?php

declare(strict_types=1);

namespace App\Validator;

use App\Model\Phonebook;
use App\Service\PhonebookService;

class PhoneNumberValidator
{
    public function __construct(private PhonebookService $service)
    {
    }

    public function validate(string $number, $full = false): array
    {
        $digits = $this->service->stringOfDigits($number);

        if (empty($digits) || strlen($digits) < Phonebook::MIN_DIGITS_IN_NUMBER
            || strlen($digits) > Phonebook::MAX_DIGITS_IN_NUMBER) {
            return ['success' => false, 'message' => 'Error to add phone number - ' . $digits];
        }

        if ($full) {
            $prefixArray = $this->service->getPrefixCountry($digits);

            if ($prefixArray['success'] === false) {
                return ['success' => false, 'message' => 'Error processing validation'];
            } else {
                return $prefixArray;
            }
        }

        return ['success' => true, 'message' => $digits];
    }
}
