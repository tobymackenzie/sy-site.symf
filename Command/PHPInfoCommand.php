<?php
namespace TJM\Bundle\BaseBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PHPInfoCommand extends Command{
	protected function configure(){
		$this
			->setName('info:php')
			->setDescription('Get information about local PHP install, AKA `phpinfo`')
		;
	}
	protected function execute(InputInterface $input, OutputInterface $output){
		phpinfo();
	}
}
