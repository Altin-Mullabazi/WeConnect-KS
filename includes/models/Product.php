<?php

class Product
{
    public ?int $id = null;
    public string $name = '';
    public string $description = '';
    public float $price = 0.0;
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
                if ($key === 'price') {
                    $this->$key = (float) $value;
                } else {
                    $this->$key = $value;
                }
            }
        }
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image,
            'category' => $this->category,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
        ];
    }

    public function getFormattedPrice(): string
    {
        return number_format($this->price, 2) . ' €';
    }
}
