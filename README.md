# php-architecture-kit/actor

Actor abstraction for PHP applications. Represents who performs actions in the system - users, system processes, or unknown sources.

## Features

- **Actor interface** - Simple contract with `identifier()` method
- **IdentifiedActor** - For actors with UUID-based identity (users, entities)
- **NamedActor** - For system processes (cron, workers, schedulers)
- **UnknownActor** - For anonymous or unidentified actors
- **ActorId** - UUID-based identity extending `php-architecture-kit/uuid`
- **PHP 7.4+** - Compatible with legacy and modern PHP

## Installation

```bash
composer require php-architecture-kit/actor
```

## Quick Start

```php
use PhpArchitecture\Actor\IdentifiedActor;
use PhpArchitecture\Actor\NamedActor;
use PhpArchitecture\Actor\UnknownActor;
use PhpArchitecture\Actor\Identity\ActorId;

// User actor (with UUID identity)
$userId = ActorId::fromString('df516cba-fb13-4f45-8335-00252f1b87e2');
$userActor = new IdentifiedActor($userId);
echo $userActor->identifier(); // 'df516cba-fb13-4f45-8335-00252f1b87e2'

// System actor (cron job, worker, etc.)
$NamedActor = new NamedActor('order-processor');
echo $NamedActor->identifier(); // 'order-processor'

// Unknown actor (anonymous, unidentified)
$unknownActor = new UnknownActor();
echo $unknownActor->identifier(); // 'unknown'
```

## Actor Implementations

| Actor | Use Case | Identifier |
|-------|----------|------------|
| `IdentifiedActor` | Users, entities with UUID | UUID string |
| `NamedActor` | Cron jobs, workers, services | Custom name |
| `UnknownActor` | Anonymous, unidentified | `'unknown'` |

## Creating Domain-Specific Actors

Extend base actors for your domain:

```php
use PhpArchitecture\Actor\IdentifiedActor;
use PhpArchitecture\Actor\Identity\ActorId;
use PhpArchitecture\Uuid\Uuid;

// Domain-specific actor ID
final class UserId extends ActorId
{
    public static function new(): static
    {
        return static::v7();
    }
}

// Domain-specific actor
class UserActor extends IdentifiedActor
{
    private string $email;
    private array $roles;

    public function __construct(UserId $id, string $email, array $roles = [])
    {
        parent::__construct($id);
        $this->email = $email;
        $this->roles = $roles;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles, true);
    }
}
```

## Usage in Aggregates

Pass Actor to aggregate methods for authorization and audit:

```php
use PhpArchitecture\Actor\Actor;
use PhpArchitecture\DomainCore\AggregateRoot;
use PhpArchitecture\DomainCore\Exception\InsufficientPrivilegeException;

class Order extends AggregateRoot
{
    private string $ownerId;

    public function cancel(Actor $actor): void
    {
        if ($actor->identifier() !== $this->ownerId) {
            throw new InsufficientPrivilegeException('Only owner can cancel order');
        }

        $this->status = 'cancelled';
        $this->recordEvent(new OrderCancelled($this->id, $actor->identifier()));
    }
}
```

## Usage in Domain Events

Track who performed actions:

```php
use PhpArchitecture\DomainCore\DomainEvent;

class OrderCancelled implements DomainEvent
{
    public function __construct(
        public readonly string $orderId,
        public readonly string $cancelledBy, // Actor identifier
        public readonly \DateTimeImmutable $cancelledAt,
    ) {}
}
```

## Creating Actor from Request (Infrastructure)

```php
// Symfony Controller
use PhpArchitecture\Actor\Actor;
use PhpArchitecture\Actor\IdentifiedActor;
use PhpArchitecture\Actor\UnknownActor;
use PhpArchitecture\Actor\Identity\ActorId;

class OrderController
{
    public function cancel(Request $request, OrderService $service): Response
    {
        $actor = $this->resolveActor($request);
        $service->cancelOrder($request->get('orderId'), $actor);
        
        return new JsonResponse(['status' => 'cancelled']);
    }

    private function resolveActor(Request $request): Actor
    {
        $userId = $request->attributes->get('user_id');
        
        if ($userId) {
            return new IdentifiedActor(ActorId::fromString($userId));
        }
        
        return new UnknownActor();
    }
}
```

## API Reference

### Actor (interface)

| Method | Description |
|--------|-------------|
| `identifier(): string` | Returns unique identifier for the actor |

### IdentifiedActor

| Method | Description |
|--------|-------------|
| `__construct(ActorId $id)` | Create actor with UUID identity |
| `identifier(): string` | Returns UUID string |

### NamedActor

| Method | Description |
|--------|-------------|
| `__construct(string $name)` | Create actor with custom name |
| `identifier(): string` | Returns the name |

### UnknownActor

| Method | Description |
|--------|-------------|
| `identifier(): string` | Returns `'unknown'` |
| `IDENTIFIER` (const) | `'unknown'` |

### ActorId

Extends `Uuid` - all UUID methods available. See [php-architecture-kit/uuid](https://github.com/php-architecture-kit/uuid).

## Testing

Package is tested with PHPUnit in the [php-architecture-kit/workspace](https://github.com/php-architecture-kit/workspace) project.

## License

MIT