<?php
namespace TJM\Bundle\BaseBundle\Command;

use Exception;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ComposerCommand extends ContainerAwareCommand{
	protected function configure(){
		$this
			->setName('composer')
			->setDescription("Run composer, the application designed for managing a symfony project's dependencies.")
			->addArgument('arguments', InputArgument::IS_ARRAY, 'Arguments to pass on to composer.  Note that options are not currently supported.')
		;
	}
	protected function execute(InputInterface $input, OutputInterface $output){
		$arguments = $input->getArgument('arguments');

		//--determine project root
		//-! need a path service to get this from the App
		$projectPath = $this->getContainer()->get('kernel')->getRootDir() . '/..';
		$binPath = $projectPath . '/bin';

		//--determine location of composer
		$whichComposerResult = shell_exec("which composer");
		$haveGlobalComposer = (empty($whichComposerResult)) ? false : true;
		if(!$haveGlobalComposer){
			$haveLocalComposer = file_exists($binPath . '/composer.phar');
		}

		//--run composer with arguments
		$composerCommand = ($haveGlobalComposer) ? 'composer' : 'php ' . $binPath . '/composer.phar';
		passthru($composerCommand . ' --working-dir=' . $projectPath . ' ' . implode(' ', $arguments), $return);
		if($return !== 0){
			throw new Exception('Composer returned an error: ' . $return);
		}
	}
}
