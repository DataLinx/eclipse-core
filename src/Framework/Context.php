<?php

namespace Eclipse\Core\Framework;

use Exception;
use Illuminate\Support\Facades\Auth;
use Eclipse\Core\Models\AppInstance;
use Eclipse\Core\Models\Language;
use Eclipse\Core\Models\Package;
use Eclipse\Core\Models\Site;
use Eclipse\Core\Models\User;

/**
 * Execution context
 *
 * @package Eclipse\Core\Framework
 */
class Context
{
    /**
     * @var AppInstance
     */
    private $app_instance;

    /**
     * @var Package
     */
    private $app_package;

    /**
     * @var Site
     */
    private $site;

    /**
     * @var Language
     */
    private $language;

    public function initialize()
    {

    }

    /**
     * Get context app instance
     *
     * @return AppInstance
     * @throws Exception
     */
    public function app_instance()
    {
        if (empty($this->app_instance)) {
            $this->app_instance = AppInstance::where([
                'site_id' => self::site()->id,
                'app_package_id' => self::app_package()->id,
            ])->first();
        }

        return $this->app_instance;
    }

    /**
     * Get context app package
     *
     * @return Package
     */
    public function app_package()
    {
        if (empty($this->app_package)) {
            // TODO App package should be detected or registered
            $this->app_package = Package::fetchByName('eclipse', 'core');
        }

        return $this->app_package;
    }

    /**
     * Get context site
     *
     * @return Site
     * @throws Exception
     */
    public function site()
    {
        if (empty($this->site)) {
            $this->site = Site::where('domain', request()->server('HTTP_HOST'))->first();

            if (empty($this->site)) {
                throw new Exception('Site not found');
            }
        }

        return $this->site;
    }

    /**
     * Get context language
     *
     * @return Language
     * @throws Exception
     */
    public function language()
    {
        if (empty($this->language)) {
            $this->language = Language::find(app()->l10n->getLanguageId());

            if (empty($this->language)) {
                throw new Exception('Language not found');
            }
        }

        return $this->language;
    }

    /**
     * Get context user, if logged in
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|User
     */
    public function user()
    {
        return Auth::user();
    }
}
