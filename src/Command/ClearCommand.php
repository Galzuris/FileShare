<?php

namespace App\Command;

use App\Domain\Interfaces\Input\FileExpiredProcessorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ClearCommand extends Command
{
    protected static $defaultName = 'app:clear';
    protected static $defaultDescription = 'Очистка устаревших файлов';

    private FileExpiredProcessorInterface $expiredProcessor;

    public function __construct(FileExpiredProcessorInterface $expiredProcessor)
    {
        $this->expiredProcessor = $expiredProcessor;
        parent::__construct(null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->expiredProcessor->processExpired();

        $io = new SymfonyStyle($input, $output);
        $io->success('Файлы очищены');

        return Command::SUCCESS;
    }
}
