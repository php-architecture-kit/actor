<?php

declare(strict_types=1);

namespace PhpArchitecture\Actor\Foundation\Exception\Provider;

use RuntimeException;
use PhpArchitecture\Actor\Foundation\Exception\ActorException;

class NamedActorNotFoundException extends RuntimeException implements ActorException
{
    
}
