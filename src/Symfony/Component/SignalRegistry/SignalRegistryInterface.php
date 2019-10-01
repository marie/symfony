<?php

namespace Symfony\Component\SignalRegistry;

interface SignalRegistryInterface
{
    public function __construct();
    public function register(int $signal, callable $callback): void;
    public function handler(int $signal): void;
}
