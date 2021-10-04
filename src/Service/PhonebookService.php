<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Phonebook;

class PhonebookService
{
    public function renderPhp(string $path, string $options): bool|string
    {
        ob_start();
        include($path);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public function stringOfDigits(string $string): string
    {
        preg_match_all('/\d/', $string, $matches);
        $number = implode('', $matches[0]);

        if (str_starts_with($number, '00')) {
            $number = substr($number, 2, strlen($number) - 1);
        }

        return $number;
    }

    private function getDataPrefixCountry(): array|null
    {
        $prefixArray = include_once(__DIR__ . '/../' . Phonebook::PATH_TO_PHONEBOOK_DATA);
        krsort($prefixArray);

        return $prefixArray;
    }

    public function getPrefixCountry(string $number): array
    {
        if ($prefixArray = self::getDataPrefixCountry()) {
            foreach ($prefixArray as $key => $value) {
                if (str_starts_with($number, (string)$key)) {
                    $keyLength = strlen((string)$key);
                    $numberLength = strlen($number);
                    $validatedArray = [
                        'prefix' => substr($number, 0, $keyLength),
                        'number' => substr($number, $keyLength, ($numberLength - 1)),
                        'name' => $value
                    ];
                    break;
                }
            }

            if (empty($validatedArray)) {
                $validatedArray = [
                    'prefix' => substr($number, 0, 2),
                    'number' => substr($number, 2, (strlen($number) - 1)),
                    'name' => 'Germany'
                ];

                if (str_starts_with($number, '02')
                    || str_starts_with($number, '03')
                    || str_starts_with($number, '07')) {
                    $validatedArray['name'] = 'Romania';
                }
            }

            return ['success' => true, 'message' => $validatedArray];
        }

        return ['success' => false];
    }

    public function toJson(array $array): string
    {
        return json_encode(['success' => $array[0], 'message' => $array[1]]);
    }
}
