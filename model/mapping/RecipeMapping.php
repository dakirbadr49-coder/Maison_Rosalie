<?php
//model/mapping/RecipeMapping`.php

declare(strict_types=1);
namespace model\mapping;
use model\abstract\AbstractMapping;

class RecipeMapping extends AbstractMapping
{
    private ?int $id = null;
    private string $title = '';
    private string $slug = '';

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int|string $v): void
    {
        $this->id = (int) $v;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $v): void
    {
        $this->title = $v;
    }
    public function getSlug(): string
    {
        return $this->slug;
    }
    public function setSlug(string $v): void
    {
        $this->slug = $v;
    }
}
