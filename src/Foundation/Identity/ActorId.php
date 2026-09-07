<?php

declare(strict_types=1);

namespace PhpArchitecture\Actor\Foundation\Identity;

interface ActorId
{
    public function toString(): string;
}
