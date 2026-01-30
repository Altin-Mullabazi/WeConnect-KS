<?php

class Event
{
    public ?int $id = null;
    public string $title = '';
    public string $description = '';
    public ?string $image = null;
    public string $event_date = '';
    public string $event_time = '';
    public string $location = '';
    public string $category = '';
    public int $user_id = 0;
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
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image,
            'event_date' => $this->event_date,
            'event_time' => $this->event_time,
            'location' => $this->location,
            'category' => $this->category,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
        ];
    }

    public function getFormattedDate(): string
    {
        return date('d M Y', strtotime($this->event_date));
    }

    public function getFormattedTime(): string
    {
        return date('H:i', strtotime($this->event_time));
    }

    public function isPast(): bool
    {
        return strtotime($this->event_date) < strtotime('today');
    }
}
