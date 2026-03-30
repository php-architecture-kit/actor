<?php

declare(strict_types=1);

namespace Tests\PhpArchitecture\Actor\Unit;

use PhpArchitecture\Actor\Actor;
use PhpArchitecture\Actor\NamedActor;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class NamedActorTest extends TestCase
{
    #[Test]
    public function implementsActorInterface(): void
    {
        $actor = new NamedActor('scheduler');

        $this->assertInstanceOf(Actor::class, $actor);
    }

    #[Test]
    public function identifierReturnsName(): void
    {
        $actor = new NamedActor('cron-job');

        $this->assertSame('cron-job', $actor->identifier());
    }

    #[Test]
    public function differentNamesProduceDifferentIdentifiers(): void
    {
        $actor1 = new NamedActor('scheduler');
        $actor2 = new NamedActor('worker');

        $this->assertNotSame($actor1->identifier(), $actor2->identifier());
    }

    #[Test]
    public function sameNameProducesSameIdentifier(): void
    {
        $actor1 = new NamedActor('cron');
        $actor2 = new NamedActor('cron');

        $this->assertSame($actor1->identifier(), $actor2->identifier());
    }

    #[Test]
    public function canBeExtended(): void
    {
        $actor = new class('custom') extends NamedActor {};

        $this->assertInstanceOf(NamedActor::class, $actor);
        $this->assertSame('custom', $actor->identifier());
    }
}
