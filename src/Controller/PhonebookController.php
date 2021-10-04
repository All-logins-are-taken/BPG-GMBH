<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Phonebook;
use App\Repository\PhonebookRepository;
use App\Service\PhonebookService;
use App\Validator\PhoneNumberValidator;

class PhonebookController
{
    private PhonebookRepository $repository;

    public function __construct(
        private Phonebook $phonebook,
        private PhoneNumberValidator $validator,
        private PhonebookService $service
    ) {
        $this->repository = new PhonebookRepository($this->phonebook, $this->validator, $service);
    }

    public function getPhoneNumberList(): string
    {
        return $this->service->renderPhp(
            '../' . Phonebook::PATH_TO_VIEW,
            $this->repository->retrieve()
        );
    }

    public function addPhoneNumber(string $number): string
    {
        return $this->repository->add($number);
    }

    public function searchPhoneNumber(string $number): string
    {
        return $this->repository->search($number);
    }

    public function deletePhoneNumber(int $id): string
    {
        return $this->repository->delete($id);
    }
}
