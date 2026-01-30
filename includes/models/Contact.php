<?php

class Contact
{
    public ?int $id = null;
    public string $name = '';
    public string $email = '';
    public string $subject = '';
    public string $message = '';
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
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
            'created_at' => $this->created_at,
        ];
    }

    public function getFormattedDate(): string
    {
        return date('d M Y H:i', strtotime($this->created_at));
    }
}
