<?php

namespace Pantheon\Terminus\Commands\Upstream\Updates;

use Consolidation\OutputFormatters\StructuredData\RowsOfFields;
use Pantheon\Terminus\Exceptions\TerminusException;

/**
 * Class ListCommand
 * @package Pantheon\Terminus\Commands\Upstream\Updates
 */
class ListCommand extends UpdatesCommand
{
    /**
     * Displays a list of new code commits available from the upstream for a site's development environment.
     *
     * @authorize
     *
     * @command upstream:updates:list
     *
     * @field-labels
     *     hash: Commit ID
     *     datetime: Timestamp
     *     message: Message
     *     author: Author
     * @return RowsOfFields
     *
     * @param string $site_env Site & development environment
     *
     * @throws TerminusException
     *
     * @usage <site>.<env> Displays a list of new code commits available from the upstream for <site>'s <env> environment.
     */
    public function listUpstreamUpdates($site_env)
    {
        list(, $env) = $this->getSiteEnv($site_env, 'dev');

        $data = [];
        foreach ($this->getUpstreamUpdatesLog($env) as $commit) {
            $data[] = [
                'hash' => $commit->hash,
                'datetime' => $commit->datetime,
                'message' => $commit->message,
                'author' => $commit->author,
            ];
        }

        if (empty($data)) {
            $this->log()->warning('There are no available updates for this site.');
        }

        // Return the output data.
        return new RowsOfFields($data);
    }
}
