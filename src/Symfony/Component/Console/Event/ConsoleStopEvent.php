<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Event;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author marie
 *
 * @final since Symfony 4.4
 */
class ConsoleStopEvent extends ConsoleEvent
{
    public function __construct(Command $command, InputInterface $input, OutputInterface $output)
    {
        parent::__construct($command, $input, $output);
    }
}
