<?php

declare(strict_types=1);

namespace App\Service;

class NamedShortGenerate
{
    private int $userId;
    private string $longUrl;
    private ?string $date;
    private string $name;

    private function __construct(
    ) {
    }

    public static function create(
        int $userId,
        string $longUrl,
        ?string $date,
        string $name
    ): self {
        $self = new self();
        $self->userId = $userId;
        $self->longUrl = $longUrl;
        $self->date = $date;
        $self->name = $name;

        return $self;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getLongUrl(): string
    {
        return $this->longUrl;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }
}
