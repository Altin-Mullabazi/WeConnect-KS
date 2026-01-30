<?php

class Validator
{
    private array $errors = [];
    private array $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function required(string $field, string $message = ''): self
    {
        if (!isset($this->data[$field]) || trim($this->data[$field]) === '') {
            $this->errors[$field] = $message ?: "Fusha '$field' eshte e detyrueshme.";
        }
        return $this;
    }

    public function email(string $field, string $message = ''): self
    {
        if (isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $message ?: "Email-i nuk eshte valid.";
        }
        return $this;
    }

    public function minLength(string $field, int $min, string $message = ''): self
    {
        if (isset($this->data[$field]) && strlen($this->data[$field]) < $min) {
            $this->errors[$field] = $message ?: "Fusha '$field' duhet te kete se paku $min karaktere.";
        }
        return $this;
    }

    public function maxLength(string $field, int $max, string $message = ''): self
    {
        if (isset($this->data[$field]) && strlen($this->data[$field]) > $max) {
            $this->errors[$field] = $message ?: "Fusha '$field' nuk mund te kete me shume se $max karaktere.";
        }
        return $this;
    }

    public function numeric(string $field, string $message = ''): self
    {
        if (isset($this->data[$field]) && !is_numeric($this->data[$field])) {
            $this->errors[$field] = $message ?: "Fusha '$field' duhet te jete numer.";
        }
        return $this;
    }

    public function positive(string $field, string $message = ''): self
    {
        if (isset($this->data[$field]) && (float)$this->data[$field] <= 0) {
            $this->errors[$field] = $message ?: "Fusha '$field' duhet te jete numer pozitiv.";
        }
        return $this;
    }

    public function date(string $field, string $format = 'Y-m-d', string $message = ''): self
    {
        if (isset($this->data[$field])) {
            $d = DateTime::createFromFormat($format, $this->data[$field]);
            if (!$d || $d->format($format) !== $this->data[$field]) {
                $this->errors[$field] = $message ?: "Data nuk eshte ne formatin e duhur.";
            }
        }
        return $this;
    }

    public function url(string $field, string $message = ''): self
    {
        if (isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_URL)) {
            $this->errors[$field] = $message ?: "URL-ja nuk eshte valide.";
        }
        return $this;
    }

    public function match(string $field1, string $field2, string $message = ''): self
    {
        if (isset($this->data[$field1], $this->data[$field2]) && $this->data[$field1] !== $this->data[$field2]) {
            $this->errors[$field2] = $message ?: "Fushat nuk perputhen.";
        }
        return $this;
    }

    public function in(string $field, array $allowed, string $message = ''): self
    {
        if (isset($this->data[$field]) && !in_array($this->data[$field], $allowed)) {
            $this->errors[$field] = $message ?: "Vlera e zgjedhur nuk eshte e vlefshme.";
        }
        return $this;
    }

    public function isValid(): bool
    {
        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getFirstError(): ?string
    {
        return $this->errors ? reset($this->errors) : null;
    }

    public static function sanitize(string $value): string
    {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }

    public static function sanitizeArray(array $data): array
    {
        return array_map(function ($value) {
            return is_string($value) ? self::sanitize($value) : $value;
        }, $data);
    }
}
