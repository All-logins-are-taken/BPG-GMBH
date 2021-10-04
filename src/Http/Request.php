<?php

declare(strict_types=1);

namespace App\Http;

class Request
{
    public array $parameters;
    public string $requestMethod;
    public string $contentType;

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
        $this->requestMethod = trim($_SERVER['REQUEST_METHOD']);
        $this->contentType = trim($_SERVER["CONTENT_TYPE"]) ?? '';
    }

    public function getBody(): array|string
    {
        if ($this->requestMethod !== 'POST') {
            return '';
        }
        $postBody = [];

        foreach ($_POST as $key => $value) {
            $postBody[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $postBody;
    }

    public function getRequest(): array
    {
        if ($this->requestMethod !== 'POST') {
            return [];
        }

        if (strcasecmp($this->contentType, 'application/json') !== 0) {
            return [];
        }
        $postContent = trim(file_get_contents("php://input"));

        return json_decode($postContent);
    }
}
