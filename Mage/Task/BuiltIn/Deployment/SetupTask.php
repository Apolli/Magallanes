<?php
/*
* This file is part of the Magallanes package.
*
* (c) Andrés Montañez <andres@andresmontanez.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Mage\Task\BuiltIn\Deployment;

use Mage\Task\AbstractTask;
use Mage\Task\Releases\IsReleaseAware;
use Mage\Task\Releases\SkipOnOverride;

/**
 * Task for Releasing a Deploy
 *
 * @author Andrés Montañez <andres@andresmontanez.com>
 */
class SetupTask extends AbstractTask
{
	/**
	 * (non-PHPdoc)
	 * @see \Mage\Task\AbstractTask::getName()
	 */
    public function getName()
    {
        return 'Setup Project [built-in]';
    }

    /**
     * Releases a Deployment: points the current symbolic link to the release directory
     * @see \Mage\Task\AbstractTask::run()
     */
    public function run()
    {
        $from = $this->getConfig()->deployment('from');

        exec('git config --global credential.helper cache');
        exec("git config --global credential.helper 'cache --timeout=300'");

        if($from != './') {
            $command = 'rm  -R '.$from.'; '.
                       'mkdir -p '.$from.'; '.
                       'cd ' . $from . '; '.
                       'git clone '.$this->getParameter('repository').' .; '.
                       'git checkout '.$this->getParameter('branch', 'master').'; ';
                       //'php composer.phar install -o;';

            $result = $this->runCommand($command);
        }

        return $result;
    }

}
