<?php

namespace App\Command;

use App\Message\MessageRedis;
use App\Message\Messenger\Transport;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\Envelope;

class MessagePush extends Command
{
    protected static $defaultName = 'message:push';

    protected function configure()
    {
        $this
            ->setDescription('Adds message to Redis')
            ->setHelp('This command adds message to Redis')
            ->addArgument('message', InputArgument::REQUIRED, 'Message');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $message = $input->getArgument('message');

        try {
            $messageRedis = new MessageRedis(['message' => $message]);

            (new Transport())->send(new Envelope($messageRedis));

            $io->info('Added the following message to Redis: ' . $message);
            $io->success('Success');

            return Command::SUCCESS;
        } catch (Exception $e) {
            $io->error('Problem with adding message to Redis "' . $message . '":' . $e->getMessage());

            return Command:: FAILURE;
        }
    }
}