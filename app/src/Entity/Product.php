<?php

namespace App\Entity;

class Product extends Entity
{
    public string $table = 'products';
    private ?int $id;
    private string $name;
    private float $price;
    private int $productType;
    private string $createdAt;

    public function __construct(
        string $name,
        float $price,
        int $productType,
        string $createdAt = null
    ) {
        $this->name = $name;
        $this->price = $price;
        $this->productType = $productType;
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

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getProductType(): int
    {
        return $this->productType;
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

    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    public function setProductType(int $productType)
    {
        $this->productType = $productType;
    }

    public function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id ?? null,
            'name' => $this->name,
            'price' => $this->price,
            'product_type' => $this->productType,
            'created_at' => $this->createdAt
        ];
    }
}
