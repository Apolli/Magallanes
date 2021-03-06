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
class FixPermissionsTask extends AbstractTask
{
	/**
	 * (non-PHPdoc)
	 * @see \Mage\Task\AbstractTask::getName()
	 */
    public function getName()
    {
        return 'Symfony v2 - Fix Permissions [built-in]';
    }

    /**
     * Dumps Assetics
     * @see \Mage\Task\AbstractTask::run()
     */
    public function run()
    {
        $command = 'chmod -R 777 app/cache app/logs';
        $result = $this->runCommand($command);

        return $result;
    }
}