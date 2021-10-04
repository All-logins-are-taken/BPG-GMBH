<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOStatement;

class RDBMS implements Database
{
    protected ?PDO $db = null;

    public function connect(string $dsn, string $user = '', string $pass = '', array $options = []): void
    {
        $this->db = new PDO($dsn, $user, $pass, $options);
    }

    public function prepare(string $sql): ?PDOStatement
    {
        return $this->db->prepare($sql);
    }

    public function last(): string
    {
        return $this->db->lastInsertId();
    }
}
