<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
	name: 'app:reload-fixtures',
	description: 'Drops and recreates the database, then loads fixtures, ensuring IDs always start at 1.',
)]
class ReloadFixturesCommand extends Command
{
	protected function configure(): void
	{
		$this->addArgument('env', InputArgument::REQUIRED, 'Environment (dev or test)');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$sstyle = new SymfonyStyle($input, $output);
		$env = $input->getArgument('env');

		$sstyle->title('Initialisation');
		$application = $this->getApplication();
		$application->setAutoExit(false);

		$sstyle->title('Dropping the database');
		$application->run(new ArrayInput([
			'command' => 'doctrine:database:drop',
			"--env" => $env,
			"--force" => true
		]));

		$sstyle->title('Recreating the database');
		$application->run(new ArrayInput([
			'command' => 'doctrine:database:create',
			"--env" => $env,
			"--if-not-exists" => true
		]));
		$application->run(new ArrayInput([
			'command' => 'doctrine:schema:update',
			"--env" => $env,
			"--force" => true
		]));

		$sstyle->title('Loading the fixtures');
		$application->run(new ArrayInput([
			'command' => 'doctrine:fixtures:load',
			"--env" => $env,
			"--no-interaction" => true
		]));

		return Command::SUCCESS;
	}
}
