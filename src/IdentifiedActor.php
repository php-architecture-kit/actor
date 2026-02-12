<?php

declare(strict_types=1);

namespace PhpArchitecture\Actor;

use PhpArchitecture\Actor\Identity\ActorId;

class IdentifiedActor implements Actor
{
    protected ActorId $id;

    public function __construct(
        ActorId $id
    ) {
        $this->id = $id;
    }

    final public function identifier(): string
    {
        return $this->id->toString();
    }
}
