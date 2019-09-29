<?php

namespace Symfony\Component\SignalRegistry;

final class SignalRegistry implements SignalRegistryInterface
{
    private $signals = [];

    public function __construct(bool $asynchronousMode = true)
    {
        if ($asynchronousMode) {
            pcntl_async_signals(true);
        }
    }

    public function register(int $signal, callable $callback): void
    {
        $this->signals[$signal][] = $callback;
        pcntl_signal($signal, [$this, 'handler']);
    }

    public function dispatch(): bool
    {
        return pcntl_signal_dispatch();
    }

    public function handler(int $signal): void
    {
        foreach($this->signals[$signal] as $callback) {
            $callback($signal);
        }
    }
}
