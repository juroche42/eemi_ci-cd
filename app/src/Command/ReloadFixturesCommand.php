<?php

namespace App\Command;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
	name: 'app:reload-fixtures',
	description: 'Drops and recreates the database, then loads fixtures, ensuring IDs always start at 1.',
)]
class ReloadFixturesCommand extends Command
{
	private Application $app;

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$sstyle = new SymfonyStyle($input, $output);

		$this->app = $this->getApplication();
		$this->app->setAutoExit(false);

		$sstyle->title('Dropping the database');

		$this->exec('doctrine:database:drop', ["--if-exists" => true, "--force" => true]);

		$sstyle->title('Recreating the database');

		$this->exec('doctrine:database:create', ["--if-not-exists" => true]);
		$this->exec('doctrine:migrations:sync-metadata-storage');
		$this->exec('doctrine:migrations:migrate');

		$sstyle->title('Loading the fixtures');

		$this->exec('doctrine:fixtures:load', ["--no-interaction" => true]);

		return Command::SUCCESS;
	}

	private function exec(string $command, array $flags = []): void
	{
		$this->app->run(new ArrayInput(['command' => $command, ...$flags]));
	}
}
