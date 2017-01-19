<?php

namespace Pantheon\Terminus\Site;

use Pantheon\Terminus\Exceptions\TerminusException;

/**
 * Class UnfrozenSiteAwareTrait
 * Implements the SiteAwareInterface for dependency injection of the Sites collection.
 * @package Pantheon\Terminus\Site
 */
trait UnfrozenSiteAwareTrait
{
    use SiteAwareTrait;

    /**
     * @inheritdoc
     */
    public function getUnfrozenSiteEnv($site_env_id, $default_env = null)
    {
        list($site, $env) = $this->getSiteEnv($site_env_id, $default_env);

        if (!is_null($site->get('frozen')) && in_array($env->id, ['test', 'live',])) {
            throw new TerminusException('This site is frozen. The test and live environments are unavailable.');
        }

        return [$site, $env,];
    }
}
