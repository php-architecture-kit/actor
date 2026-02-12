<?php

declare(strict_types=1);

namespace PhpArchitecture\Actor;

class SystemActor implements Actor
{
    protected string $name;

    public function __construct(
        string $name
    ) {
        $this->name = $name;
    }

    final public function identifier(): string
    {
        return $this->name;
    }
}
