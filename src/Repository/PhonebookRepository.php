<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Phonebook;
use App\Service\PhonebookService;
use App\Validator\PhoneNumberValidator;

class PhonebookRepository
{
    public function __construct(
        private Phonebook $phonebook,
        private PhoneNumberValidator $validator,
        private PhonebookService $service
    ) {
    }

    public function add(string $number): string
    {
        $exists = json_decode(self::search($number), true);

        if ($exists['success'] === false && strpos($exists['message'], 'error') === true) {
            return $this->service->toJson([false, $exists['message']]);
        } elseif ($exists['success'] === true) {
            return $this->service->toJson([false, 'Phone number ' . $exists['message']]);
        }
        $validated = $this->validator->validate($number, true);

        if ($validated['success'] === false) {
            return $this->service->toJson([$validated['success'], $validated['message']]);
        }
        $query = 'INSERT INTO `all_phone_book` (`prefix`, `number`, `name`, `updated_at`, `deleted`) 
        VALUES("' . $validated["message"]["prefix"] . '", "' . $validated["message"]["number"] . '", "' . $validated["message"]["name"] . '", NOW(), 0)';

        $this->phonebook->query($query);
        $this->phonebook->execute();

        return $this->service->toJson([true, 'Inserted with Id: '. $this->phonebook->last()]);
    }

    public function retrieve(): string
    {
        $query = 'SELECT * FROM `all_phone_book` ORDER BY `id` DESC';

        $this->phonebook->query($query);
        $list = $this->phonebook->all();

        if (empty($list)) {
            return $this->service->toJson([false, 'There is no phone numbers']);
        }

        return $this->service->toJson([true, $list]);
    }

    public function search(string $number): string
    {
        $validated = $this->validator->validate($number);

        if ($validated['success'] === false) {
            return $this->service->toJson([$validated['success'], $validated['message']]);
        }
        $query = 'SELECT * FROM `all_phone_book` WHERE CONCAT(`prefix`, `number`) = ' . $validated['message'];

        $this->phonebook->query($query);
        $exists = $this->phonebook->single();

        if ($exists) {
            return $this->service->toJson([true, 'Exists with Id: ' . $exists['id']]);
        }

        return $this->service->toJson([false, 'There is no such phone number']);
    }

    public function delete(int $id): string
    {
        $query = 'UPDATE `all_phone_book` SET `deleted` = 1 WHERE `id` = ' . $id;

        $this->phonebook->query($query);
        $deleted = $this->phonebook->execute();

        if (empty($deleted)) {
            return $this->service->toJson([false, 'There is no phone number with id ' . $id]);
        }

        return $this->service->toJson([true, 'Phone number deleted']);
    }
}
