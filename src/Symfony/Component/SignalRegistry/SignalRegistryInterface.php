<?php

namespace Symfony\Component\SignalRegistry;

interface SignalRegistryInterface
{
    public function __construct(bool $asynchronousMode = true);
    public function register(int $signal, callable $callback): void;
    public function dispatch(): bool;
    public function handler(int $signal): void;
}
