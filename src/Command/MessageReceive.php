<?php

namespace App\Command;

use App\Message\Messenger\Transport;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\Envelope;

class MessageReceive extends Command
{
    protected static $defaultName = 'message:receive';

    protected function configure()
    {
        $this
            ->setDescription('Receive message from Redis')
            ->setHelp('This command receive message from Redis');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $transport = new Transport();
            /** @var Envelope $envelope */
            foreach ($transport->get() as $envelope) {
                $io->info('Message: ' . $envelope->getMessage()->getData()['message']);
                $transport->reject($envelope);
            }

            $io->success('Success');
            return Command::SUCCESS;
        } catch (Exception $e) {
            $io->error('Problem with getting message from Redis:' . $e->getMessage());

            return Command:: FAILURE;
        }
    }
}