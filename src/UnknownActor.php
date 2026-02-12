<?php

declare(strict_types=1);

namespace PhpArchitecture\Actor;

class UnknownActor implements Actor
{
    public const IDENTIFIER = 'unknown';

    public function identifier(): string
    {
        return self::IDENTIFIER;
    }
}
