<?php

namespace App\Entity;

class ProductType extends Entity
{
    public string $table = 'product_types';
    private ?int $id;
    private string $name;
    private float $percentage;
    private string $createdAt;

    public function __construct($name, $percentage, $createdAt = null) {
        $this->name = $name;
        $this->percentage = $percentage;
        $this->createdAt = $createdAt ?: date('Y-m-d H:i:s');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPercentage():float
    {
        return $this->percentage;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setPercentage(float $percentage)
    {
        $this->percentage = $percentage;
    }

    public function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function toArray() {
        return [
            'id' => $this->id ?? null,
            'name' => $this->name,
            'percentage' => $this->percentage,
            'created_at' => $this->createdAt
        ];
    }
}
