<?php

declare(strict_types=1);

namespace BountyHunter\UI\CLI\Bounty;

use BountyHunter\Domain\Bounty\BonusRepositoryInterface;
use BountyHunter\Domain\Bounty\Specification\NotSandedMoneySpecification;
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

    /** @var BonusRepositoryInterface */
    private $bonusRepository;

    /**
     * DeliveryCommand constructor.
     *
     * @param BonusRepositoryInterface $bonusRepository
     */
    public function __construct(BonusRepositoryInterface $bonusRepository)
    {
        parent::__construct(null);
        $this->bonusRepository = $bonusRepository;
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
        $pack = (int)$pack;
        $output->writeln('Pack size: '.$pack);

        $total = $this->bonusRepository->count(new NotSandedMoneySpecification());
        if ($total === 0) {
            $output->writeln([
                'No bonuses to send exit ...',
                '===================',
                ''
            ]);

            return 1;
        }

        $output->writeln('Total bonuses to send: '.$total);

        if ($total <= $pack) {
            return $this->proceedAll();
        }

        return $this->proceedByPack($total, $pack);
    }

    /**
     * @return int
     */
    private function proceedAll(): int
    {
        //TODO make logic;
        return 0;
    }

    /**
     * @param int $total
     * @param int $packSize
     *
     * @return int
     */
    private function proceedByPack(int $total, int $packSize): int
    {
        foreach (\range(0, $total, $packSize) as $key => $pack) {
            //$bonuses = $this->bonusRepository->match(new NotSandedMoneySpecification($packSize, $key));
            echo "#{$key}" . 'DO something'.PHP_EOL;
        }

        return 0;
    }
}
