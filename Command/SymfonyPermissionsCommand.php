<?php
namespace TJM\Bundle\BaseBundle\Command;

use Exception;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SymfonyPermissionsCommand extends ContainerAwareCommand{
	protected function configure(){
		$this
			->setName('init:permissions')
			->setDescription('Set permissions on log and cache directories.  Remove exising files first.  Permissions part requires sudo abilities.')
			->addArgument('aclType', InputArgument::REQUIRED, 'What type of ACL mechanism to use.  One of (chmod|setfacl|none)')
		;
	}
	protected function execute(InputInterface $input, OutputInterface $output){
		$verbose = ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE);
		$aclType = $input->getArgument('aclType');
		if($aclType){
			switch($aclType){
				case 'chmod':
				case 'setfacl':
					//--continue
				break;
				case 'none':
					throw new Exception("There is no way to set the permissions directly.  Please add 'umask(0000);' to app.php and app_dev.php to bypass the need for setting permissions, though it has some security implications.");
				break;
				default:
					throw new Exception("Unrecognized option.  Please try another option.  Try 'none' if your system doesn't support ACLs.");
				break;
			}

			//-! need to create a service to get these paths from
			$appPath = $this->getContainer()->get('kernel')->getRootDir();
			//-# prefer Symfony 3 directory structure, but support Symfony 2 directory structure
			$varPath = $appPath . '/../var';
			if(!is_dir($varPath)){
				$varPath = $appPath;
			}
			$cachePath = $varPath . "/cache";
			$logPath = $varPath . "/logs";
			if(is_dir($cachePath)){
				if($verbose){
					$output->writeln("Clearing cache folder\n");
				}
				passthru("rm -rf {$cachePath}/*");
			}else{
				if($verbose){
					$output->writeln("Creating cache folder\n");
				}
				passthru("mkdir {$cachePath}");
			}
			if(is_dir($logPath)){
				if($verbose){
					$output->writeln("Clearing log folder\n");
				}
				passthru("rm -rf {$logPath}/*");
			}else{
				if($verbose){
					$output->writeln("Creating log folder\n");
				}
				passthru("mkdir {$logPath}");
			}

			$apacheUser = exec("ps aux | grep -E '[a]pache|[h]ttpd' | grep -v root | head -1 | cut -d\  -f1");

			switch($aclType){
				case 'chmod':
					$command = "sudo chmod +a \"`whoami` allow delete,write,append,file_inherit,directory_inherit\" {$cachePath} {$logPath}";
					if($apacheUser){
						$command .= " && sudo chmod +a \"{$apacheUser} allow delete,write,append,file_inherit,directory_inherit\" {$cachePath} {$logPath}";
					}
					if($verbose){
						$output->writeln("Running: {$command}");
					}
					passthru($command, $return);
				break;
				case 'setfacl':
					$apacheCommandPart = ($apacheUser)
						? " -m u:{$apacheUser}:rwX"
						: ''
					;
					$command = "sudo setfacl -R {$apacheCommandPart} -m u:`whoami`:rwX {$cachePath} {$logPath} && sudo setfacl -dR {$apacheCommandPart} -m u:`whoami`:rwX {$cachePath} {$logPath}";
					if($verbose){
						$output->writeln("Running: {$command}");
					}
					passthru($command, $return);
				break;
			}
		}else{
			throw new Exception(
				"Choose what type of ACLs your system supports.  Options:\n"
				. " - chmod: supports `chmod +a` syntax\n"
				. " - setfacl: supports `setfacl` command\n"
				. " - none: doesn't have ACL support\n"
			);
		}
	}
}
