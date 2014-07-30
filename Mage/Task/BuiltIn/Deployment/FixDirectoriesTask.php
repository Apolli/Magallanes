<?php
/*
 * This file is part of the Magallanes package.
*
* (c) Andrés Montañez <andres@andresmontanez.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Mage\Task\BuiltIn\Symfony2;

use Mage\Task\AbstractTask;

/**
 * Task for Dumping Assetics
 *
 * @author Andrés Montañez <andres@andresmontanez.com>
 */
class FixDirectoriesTask extends AbstractTask
{
	/**
	 * (non-PHPdoc)
	 * @see \Mage\Task\AbstractTask::getName()
	 */
    public function getName()
    {
        return 'Deplyoment - Fix Directories [built-in]';
    }

    /**
     * Dumps Assetics
     * @see \Mage\Task\AbstractTask::run()
     */
    public function run()
    {
        $from = $this->getConfig()->deployment('from');

        $command = 'mv  .'.$from.'* .';
        $result = $this->runCommand($command);

        return $result;
    }
}