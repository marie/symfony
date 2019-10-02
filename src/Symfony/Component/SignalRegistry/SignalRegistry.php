<?php

namespace Symfony\Component\SignalRegistry;

final class SignalRegistry implements SignalRegistryInterface
{
    private $signals = [];

    public function __construct()
    {
        pcntl_async_signals(true);
    }

    public function register(int $signal, callable $callback): void
    {
        if (!isset($this->signals[$signal])) {
            $previousCallback = pcntl_signal_get_handler($signal);
            if (is_callable($previousCallback)) {
                $this->signals[$signal][] = $previousCallback;
            }
        }

        $this->signals[$signal][] = $callback;
        pcntl_signal($signal, [$this, 'handler']);
    }

    public function handler(int $signal): void
    {
        foreach($this->signals[$signal] as $callback) {
            $callback($signal);
        }
    }
}
