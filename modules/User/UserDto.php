<?php

declare(strict_types=1);

namespace Modules\User;

use App\Models\User;

readonly class UserDto
{
    public function __construct(
        public int $id,
        public string $email
    ) {}

    public static function fromEloquentModel(User $user): self
    {
        return new self(
            id: $user->id,
            email: $user->email
        );
    }
}
