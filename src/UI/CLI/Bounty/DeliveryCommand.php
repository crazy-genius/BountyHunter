<?php

declare(strict_types=1);

namespace BountyHunter\UI\CLI\Bounty;

use BountyHunter\Domain\Bounty\BonusRepositoryInterface;
use BountyHunter\Domain\Bounty\Entity\BountyInterface;
use BountyHunter\Domain\Bounty\Specification\NotSendedMoneySpecification;
use Doctrine\ORM\EntityManagerInterface;
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
    /** @var EntityManagerInterface */
    private $entityManage;

    /**
     * DeliveryCommand constructor.
     *
     * @param BonusRepositoryInterface $bonusRepository
     */
    public function __construct(BonusRepositoryInterface $bonusRepository, EntityManagerInterface $entityManage)
    {
        parent::__construct(null);
        $this->bonusRepository = $bonusRepository;
        $this->entityManage = $entityManage;
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

        if (!\is_numeric($pack) || (int)$pack === 0) {
            throw new InvalidArgumentException('Pack should to be a numeric greater than zero');
        }
        $pack = (int)$pack;
        $output->writeln('Pack size: '.$pack);

        $total = $this->bonusRepository->count(new NotSendedMoneySpecification());
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
            return $this->proceedAll($output);
        }

        return $this->proceedByPack($output, $total, $pack);
    }

    /**
     * @param OutputInterface $output
     *
     * @return int
     */
    private function proceedAll(OutputInterface $output): int
    {
        $count = 0;
        foreach ($this->bonusRepository->match(new NotSendedMoneySpecification()) as $bounty) {
            $this->sendMoney($bounty);
            $this->entityManage->persist($bounty);
            $count++;
        }

        $this->entityManage->flush();

        $output->writeln("Complete. {$count} was send.");

        return 0;
    }

    /**
     * @param int $total
     * @param int $packSize
     *
     * @return int
     */
    private function proceedByPack(OutputInterface $output, int $total, int $packSize): int
    {
        $count = 0;

        foreach (\range(0, $total, $packSize) as $key => $pack) {
            $bonuses = $this->bonusRepository->match(new NotSendedMoneySpecification($packSize, $key));

            foreach ($bonuses as $bounty) {
                $this->sendMoney($bounty);
            }

            $this->entityManage->persist($bonuses);
            $this->entityManage->flush();
        }

        $output->writeln("Complete. {$count} was send.");

        return 0;
    }

    /**
     * @param BountyInterface $bounty
     */
    private function sendMoney(BountyInterface $bounty): void
    {
        $bounty->send();
        //TODO some extra logic
    }
}
