<?php

class User
{
    public ?int $id = null;
    public string $emri = '';
    public string $mbiemri = '';
    public string $email = '';
    public string $password = '';
    public string $role = 'user';
    public ?string $created_at = null;

    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    public function fill(array $data): self
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'emri' => $this->emri,
            'mbiemri' => $this->mbiemri,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role,
            'created_at' => $this->created_at,
        ];
    }

    public function getFullName(): string
    {
        return $this->emri . ' ' . $this->mbiemri;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
