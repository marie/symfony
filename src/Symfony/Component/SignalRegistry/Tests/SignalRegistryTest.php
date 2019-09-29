<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\SignalRegistry\SignalRegistry;

class SignalRegistryTest  extends TestCase
{
    public function tearDown(): void
    {
        pcntl_async_signals(false);
        pcntl_signal(SIGUSR1, SIG_DFL);
        pcntl_signal(SIGUSR2, SIG_DFL);
    }

    public function testOneCallbackForASignal_AsyncMode_signalIsHandled()
    {
        $signalRegistry = new SignalRegistry();

        $isHandled = false;
        $signalRegistry->register(SIGUSR1, function() use (&$isHandled) {
            $isHandled = true;
        });

        posix_kill(posix_getpid(), SIGUSR1);

        $this->assertTrue($isHandled);
    }

    public function testTwoCallbacksForASignal_AsyncMode_bothCallbacksAreCalled()
    {
        $signalRegistry = new SignalRegistry();

        $isHandled1 = false;
        $signalRegistry->register(SIGUSR1, function() use (&$isHandled1) {
            $isHandled1 = true;
        });

        $isHandled2 = false;
        $signalRegistry->register(SIGUSR1, function() use (&$isHandled2) {
            $isHandled2 = true;
        });

        posix_kill(posix_getpid(), SIGUSR1);

        $this->assertTrue($isHandled1);
        $this->assertTrue($isHandled2);
    }

    public function testTwoSignals_AsyncMode_signalsAreHandled()
    {
        $signalRegistry = new SignalRegistry();

        $isHandled1 = false;
        $isHandled2 = false;

        $signalRegistry->register(SIGUSR1, function() use (&$isHandled1) {
            $isHandled1 = true;
        });

        posix_kill(posix_getpid(), SIGUSR1);

        $this->assertTrue($isHandled1);
        $this->assertFalse($isHandled2);

        $signalRegistry->register(SIGUSR2, function() use (&$isHandled2) {
            $isHandled2 = true;
        });

        posix_kill(posix_getpid(), SIGUSR2);

        $this->assertTrue($isHandled2);
    }

    public function testOneCallbackForASignal_DispatchMode_signalIsNotHandled()
    {
        $signalRegistry = new SignalRegistry(false);

        $isHandled = false;
        $signalRegistry->register(SIGUSR1, function() use (&$isHandled) {
            $isHandled = true;
        });

        posix_kill(posix_getpid(), SIGUSR1);

        $this->assertFalse($isHandled);
    }

    public function testOneCallbackForASignal_DispatchMode_signalIsHandled()
    {
        $signalRegistry = new SignalRegistry(false);

        $isHandled = false;
        $signalRegistry->register(SIGUSR1, function() use (&$isHandled) {
            $isHandled = true;
        });

        posix_kill(posix_getpid(), SIGUSR1);
        $signalRegistry->dispatch();

        $this->assertTrue($isHandled);
    }
}
