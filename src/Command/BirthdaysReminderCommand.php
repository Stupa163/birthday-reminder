<?php

namespace App\Command;

use App\Event\BirthdayEvent;
use App\Repository\FriendRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class BirthdaysReminderCommand extends Command
{
    protected static $defaultName = 'BirthdaysReminderCommand';

    /** @var FriendRepository $friendRepository */
    private $friendRepository;

    /** @var EventDispatcher $eventDispatcher */
    private $eventDispatcher;

    public function __construct(FriendRepository $friendRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->friendRepository = $friendRepository;
        $this->eventDispatcher = $eventDispatcher;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Send an SMS alert for today\'s birthdays')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $friends = $this->friendRepository->findBirthdaysOfTheDay();

        foreach ($friends as $friend) {
            $event = new BirthdayEvent($friend);
            $this->eventDispatcher->dispatch($event);
        }

        $io->writeln(count($friends) .' birthdays have been reminded today, see you tomorrow');

        return Command::SUCCESS;
    }
}
