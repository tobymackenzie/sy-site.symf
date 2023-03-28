<?php
namespace TJM\SySite;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class TJMSySiteBundle extends Bundle{
	//-@ via <https://github.com/symfony/symfony/pull/32845/files>, should use new directory structure
	public function getPath(): string{
		return \dirname(__DIR__);
	}
}

