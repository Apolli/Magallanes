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
class PrepareConfigTask extends AbstractTask
{
	/**
	 * (non-PHPdoc)
	 * @see \Mage\Task\AbstractTask::getName()
	 */
    public function getName()
    {
        return 'Symfony v2 - Prepare Config [built-in]';
    }

    /**
     * Dumps Assetics
     * @see \Mage\Task\AbstractTask::run()
     */
    public function run()
    {
        $env = $this->getParameter('type', '');

        $command = 'rm app/config/parameters.php';
        $result = $this->runCommandRemote($command);

        $command = 'mv app/config/parameters.'.$env.'.php app/config/parameters.php';
        $result = $this->runCommandRemote($command);

        return $result;
    }
}