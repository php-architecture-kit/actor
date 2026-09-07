<?php

declare(strict_types=1);

namespace PhpArchitecture\Actor\Foundation\Provider;

use PhpArchitecture\Actor\Foundation\Actor;
use PhpArchitecture\Actor\Foundation\Exception\Provider\IdentifiedActorNotFoundException;
use PhpArchitecture\Actor\Foundation\Identity\ActorId;

interface IdentifiedActorProviderInterface
{
    /**
     * @throws IdentifiedActorNotFoundException when actor with given id is not found
     */
    public function getIdentifiedActor(ActorId $id): Actor;
}
