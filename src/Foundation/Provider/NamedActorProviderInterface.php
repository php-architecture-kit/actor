<?php

declare(strict_types=1);

namespace PhpArchitecture\Actor\Foundation\Provider;

use PhpArchitecture\Actor\Foundation\Actor;
use PhpArchitecture\Actor\Foundation\Exception\Provider\NamedActorNotFoundException;

interface NamedActorProviderInterface
{
    /**
     * @throws NamedActorNotFoundException when actor with given name is not found
     */
    public function getNamedActor(string $name): Actor;
}
