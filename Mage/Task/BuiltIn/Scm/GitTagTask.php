<?php
/*
 * This file is part of the Magallanes package.
*
* (c) Andrés Montañez <andres@andresmontanez.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Mage\Task\BuiltIn\Scm;

use Mage\Task\AbstractTask;
use Mage\Task\SkipException;

/**
 * Task for Updating a Working Copy
 *
 * @author Andrés Montañez <andres@andresmontanez.com>
 */
class GitTagTask extends AbstractTask
{
	/**
	 * Name of the Task
	 * @var string
	 */
    private $name = 'SCM Tag [built-in]';

    /**
     * (non-PHPdoc)
     * @see \Mage\Task\AbstractTask::getName()
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * (non-PHPdoc)
     * @see \Mage\Task\AbstractTask::init()
     */
    public function init()
    {
        switch ($this->getConfig()->general('scm')) {
            case 'git':
                $this->name = 'SCM Tag (GIT) [built-in]';
                break;
        }
    }

    /**
     * Updates the Working Copy
     * @see \Mage\Task\AbstractTask::run()
     */
    public function run()
    {
        switch ($this->getConfig()->general('scm')) {
            case 'git':
                echo "\nCreate GIT Tag (yes/no)?\n";
                $handle = fopen ("php://stdin","r");
                $line = fgets($handle);
                if(trim($line) == 'yes') {

                    // remove old tags
                    echo "\nFetch all Tags";
                    $tags = array();
                    exec('git for-each-ref --format="%(taggerdate): %(refname)" --sort=-taggerdate refs/tags', $tags);

                    // get current tag id
                    $nextId = 1;
                    if(isset($tags[0])) {
                        $tagParts = explode('-', $tags[0]);
                        $tagId = array_pop($tagParts);
                        $nextId = $tagId+1;
                    }
                    echo "\nRemove old Tags";
                    $removeTags = array_slice($tags, 20);
                    $command = '';
                    foreach($removeTags as $tag) {
                        $tagParts = explode('/', $tag);
                        $tagName = array_pop($tagParts);

                        $command .= "git tag -d $tagName;";


                        $tagParts = explode(':', $tag);
                        $tagName = array_pop($tagParts);

                        $command .= "git push origin :".trim($tagName).";";
                    }

                    $command .= "git push --tags;";
                    if($command) {
                        $result = $this->runCommandLocal($command);
                    }

                    echo "\nAdd new Tag";
                    // get current revision
                    $currentRevision = array();
                    exec('git rev-parse HEAD', $currentRevision);

                    // create new tag
                    $result = $this->runCommandLocal("git tag -am \"auto-tag-$nextId\" auto-tag-$nextId $currentRevision[0]; git push origin auto-tag-$nextId;");
                }
                break;

            default:
                throw new SkipException;
                break;
        }

        $result = $this->runCommandLocal($command);
        $this->getConfig()->reload();

        return $result;
    }
}