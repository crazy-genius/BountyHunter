<?php

declare(strict_types=1);

namespace BountyHunter\UI\CLI\Bounty;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DeliveryCommand
 * @package BountyHunter\UI\CLI\Bonus
 */
class DeliveryCommand extends Command
{
    /** @var string */
    protected static $defaultName = 'bounty:delivery:money';

    /**
     * DeliveryCommand constructor.
     */
    public function __construct()
    {
        parent::__construct(null);
    }

    /** @inheritDoc */
    protected function configure()
    {
        $this
            ->setDescription('Send all bonus money')
            ->setHelp('This command allows you to send all money which was not sent...')

            ->addOption('pack', 'p', InputOption::VALUE_REQUIRED, 'number of pack for batch sent process')
        ;
    }

    /** @inheritDoc */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Money sender',
            '============',
            '',
        ]);

        $pack = $input->getOption('pack');

        if (!\is_numeric($pack) || $pack === 0) {
            throw new InvalidArgumentException('Pack should to be a numeric greater than zero');
        }

        $output->writeln('Pack size: '.$pack);
    }
}
