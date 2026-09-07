<?php

declare(strict_types=1);

namespace PhpArchitecture\Actor\Foundation\Exception\Provider;

use RuntimeException;
use PhpArchitecture\Actor\Foundation\Exception\ActorException;

class IdentifiedActorNotFoundException extends RuntimeException implements ActorException
{
    
}
