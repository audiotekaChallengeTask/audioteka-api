<?php
declare(strict_types=1);

namespace App\Command;

use Fidry\AliceDataFixtures\LoaderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadFixturesCommand extends Command
{
    private LoaderInterface $loader;
    private string          $rootDir;

    public function __construct(LoaderInterface $loader, string $rootDir)
    {
        parent::__construct('database:load-fixtures');
        $this->loader  = $loader;
        $this->rootDir = $rootDir;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->loader->load(
            [
                $this->rootDir . '/tests/functional/DataFixtures/ORM/resources/products.yml'
            ]
        );

        return Command::SUCCESS;
    }

}
