<?php

declare(strict_types=1);

namespace App\Model;

use App\Database\RDBMS;
use App\Service\PhonebookService;
use PDOException;
use PDOStatement;

class Phonebook
{
    public const PATH_TO_PHONEBOOK_DATA = 'Data/PhonePrefixesWithCountries.php';
    public const MIN_DIGITS_IN_NUMBER = 6;
    public const MAX_DIGITS_IN_NUMBER = 20;
    public const PATH_TO_VIEW = 'View/phonebook.php';
    public const DATABASE_SOURCE = 'mysql';

    private PDOStatement $statement;

    public function __construct(private ?RDBMS $database, private PhonebookService $service)
    {
        $dsn = self::DATABASE_SOURCE . ':host=' . getenv('MYSQL_HOST') . ';dbname=' . getenv('MYSQL_DATABASE');

        try {
            $this->database->connect($dsn, getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), []);

            return $this->service->toJson([true, 'Connected to ' . self::DATABASE_SOURCE]);
        } catch (PDOException $e) {
            return $this->service->toJson([false, 'Database ' . self::DATABASE_SOURCE . ' connection error']);
        }
    }

    public function query(string $sql): void
    {
        $this->statement = $this->database->prepare($sql);
    }

    public function execute(): bool
    {
        return $this->statement->execute();
    }

    public function all(): bool|array
    {
        $this->execute();

        return $this->statement->fetchAll();
    }

    public function single(): mixed
    {
        $this->execute();

        return $this->statement->fetch();
    }

    public function last(): string
    {
        return $this->database->last();
    }
}
