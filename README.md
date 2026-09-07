# php-architecture-kit/actor

## Usage

```php
class SomeActor implements Actor
{}

class SomeAggregateRoot
{
    public function doSthMethod(SomeActor $actor, /* ... other arguments */): void
    {
        
    }
}
```
