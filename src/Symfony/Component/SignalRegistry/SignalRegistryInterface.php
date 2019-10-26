<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\SignalRegistry;

interface SignalRegistryInterface
{
    public function __construct();

    public function register(int $signal, callable $callback): void;

    public function handler(int $signal): void;
}
