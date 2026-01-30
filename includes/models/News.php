<?php

class News
{
    public ?int $id = null;
    public string $title = '';
    public string $content = '';
    public ?string $image = null;
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
            'content' => $this->content,
            'image' => $this->image,
            'category' => $this->category,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
        ];
    }

    public function getExcerpt(int $length = 150): string
    {
        $text = strip_tags($this->content);
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . '...';
    }

    public function getFormattedDate(): string
    {
        return date('d M Y', strtotime($this->created_at));
    }
}
