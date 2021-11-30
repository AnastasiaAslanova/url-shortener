<?php

declare(strict_types=1);

namespace App\Service;

class ShortGenerate
{
    private int $userId;
    private string $longUrl;
    private ?string $date;
    private bool $withKey;

    private function __construct(
    ) {
    }

    public static function create(
        int $userId,
        string $longUrl,
        ?string $date,
        bool $withKey
    ): self {
        $self = new self();
        $self->userId = $userId;
        $self->longUrl = $longUrl;
        $self->withKey = $withKey;
        $self->date = $date;

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

    public function isWithKey(): bool
    {
        return $this->withKey;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }
}
