<?php

namespace App\Command;

use App\Entity\Friend;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateFriendCommand extends Command
{
    protected static $defaultName = 'createFriendCommand';

    /** @var EntityManagerInterface $em */
    private $em;

    /** @var ValidatorInterface $validator */
    private $validator;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Allow to create a new friend with a name and a birthday date')
            ->addArgument('name', InputArgument::REQUIRED, 'Friend\'s name')
            ->addArgument('birthdayDate', InputArgument::REQUIRED, 'Friend\'s birthday date (format d-m-Y)')
            ->setHelp('usage : php bin/console CreateFriendCommand Rémi "27-08-1998"')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $name = $input->getArgument('name');
        $birthdayDate = DateTime::createFromFormat('d-m-Y', $input->getArgument('birthdayDate'));

        $friend = new Friend($name, $birthdayDate);

        $errors = $this->validator->validate($friend);

        if ($errors->count() > 0) {
            foreach ($errors as $error) {
                $output->writeln($error->getmessage());
            }
            $io->writeln(PHP_EOL . 'Unable to create your friend' . $name);

            return Command::FAILURE;
        }

        $this->em->persist($friend);
        $this->em->flush();

        $io->writeln('Your friend ' . $name . ' has successfully been added to the database');

        return Command::SUCCESS;
    }
}
