<?php

namespace Eclipse\Core\Framework;

use Exception;
use Illuminate\Support\Facades\Cookie;
use Eclipse\Core\Models\Language;

/**
 * Class L10n
 * @package Eclipse\Core\Framework
 */
class L10n
{
    const COOKIE_NAME = 'lid';

    /**
     * @var string Current domain
     */
    private $current_domain;

    /**
     * @var bool Is language validation enabled
     */
    private $language_validation_enabled = true;

    /**
     * @var string Current language ID
     */
    private $language_id;

    /**
     * @var string Current data language ID
     */
    private $data_language_id;

    /**
     * @var string[] All system supported languages
     */
    private $all_languages = ['en', 'sl', 'hr', 'sr', 'de', 'it'];

    /**
     * @var string[] Valid languages for the current context
     */
    private $valid_languages = ['en', 'sl'];

    /**
     * L10n constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        require_once base_path('vendor/datalinx/gettext-context/src/gettext-context.php');
    }

    /**
     * Initialize the L10n library
     *
     * @return $this
     * @throws Exception
     */
    public function initialize()
    {
        try {
            $this->setLanguage($this->detectLanguage());
        }
        catch (Exception $exception) {
            throw new Exception('Could not initialize L10n: '. $exception->getMessage(), 0, $exception);
        }

        return $this;
    }

    /**
     * Bind gettext domain
     *
     * @param string $domain Domain
     * @param string $directory Path to the locales directory
     * @param false $set_domain Also activate the domain
     * @return $this
     * @throws Exception
     */
    public function bindDomain($domain, $directory, $set_domain = FALSE)
    {
        if ( ! file_exists($directory)) {
            throw new Exception("Directory $directory does not exist");
        }

        bindtextdomain($domain, $directory);

        if ($set_domain) {
            $this->setDomain($domain);
        }

        return $this;
    }

    /**
     * Set gettext domain as active
     *
     * @param string $domain Domain
     * @param bool $is_tmp Only as a temporary switch, after which resetDomain() will be used
     * @return $this
     * @throws Exception
     */
    public function setDomain($domain, $is_tmp = FALSE)
    {
        if (empty($domain)) {
            throw new Exception('Domain parameter is required');
        }

        if ($is_tmp) {
            $this->current_domain = textdomain(NULL);
        }

        if ( ! textdomain($domain)) {
            throw new Exception("Could not set domain to $domain");
        }

        return $this;
    }

    /**
     * Reset the domain back after a temporary switch
     *
     * @return $this
     * @throws Exception
     */
    public function resetDomain()
    {
        if (isset($this->current_domain)) {
            $c_domain = $this->current_domain;
            $this->current_domain = NULL;
            return $this->setDomain($c_domain);
        }

        return $this;
    }

    /**
     * Set active language
     *
     * @param string $language_id Language ID
     * @param string|null $data_language_id Data language ID
     * @param bool $save Save the selection in a cookie
     * @return $this
     * @throws Exception
     */
    public function setLanguage($language_id, $data_language_id = null, $save = false)
    {
        if (empty($data_language_id)) {
            $data_language_id = $language_id;
        }

        // Check validity
        if ( ! $this->isValid($language_id)) {
            throw new Exception("\"$language_id\" is not a valid UI language");
        }

        if ( ! $this->isValid($data_language_id, true)) {
            throw new Exception("\"$data_language_id\" is not a valid data language");
        }

        // Set as current
        $this->language_id = $language_id;
        $this->data_language_id = $data_language_id;

        // Update Laravel config
        config(['app.locale' => $this->language_id]);

        // Fetch language object
        $language = Language::find($language_id);

        // Set enviroment
        setlocale(LC_ALL, $language->system_locale);

        // Always use C for numbers
        setlocale(LC_NUMERIC, 'C');

        // Save if requested
        if ($save) {
            Cookie::queue(self::COOKIE_NAME, $language_id, 5*365*24*60);
        }

        return $this;
    }

    /**
     * Disable or enable language validation
     *
     * @param bool $status Status to set
     * @return $this
     */
    public function setLanguageValidation($status = true)
    {
        $this->language_validation_enabled = $status;

        return $this;
    }

    /**
     * Check if the provided language is a valid selection for the current context
     *
     * @param string $language_id Language ID
     * @param bool $is_data Check against data languages
     * @return bool
     */
    public function isValid($language_id, $is_data = false)
    {
        if ($this->language_validation_enabled) {
            return in_array($language_id, $this->valid_languages, true);
        }

        return in_array($language_id, $this->all_languages, true);
    }

    /**
     * Detect which language should be used for this request
     *
     * @return string
     */
    private function detectLanguage()
    {
        // Is there a saved cookie?
        $cookie = Cookie::get(self::COOKIE_NAME);

        if ($cookie and $this->isValid($cookie)) {
            return $cookie;
        }

        // Detect the client language preference
        $client_langs = request()->server('HTTP_ACCEPT_LANGUAGE');

        if (strpos($client_langs, ','))
        {
            $langs = explode(',', str_replace(';', ',', $client_langs));

            foreach ($langs as $lang)
            {
                if ($this->isValid($lang))
                {
                    return $lang;
                }
            }
        }

        return config('app.locale');
    }

    /**
     * Get current language ID
     *
     * @return string
     */
    public function getLanguageId()
    {
        return $this->language_id;
    }

    /**
     * Get current data language ID
     *
     * @return string
     */
    public function getDataLanguageId()
    {
        return $this->data_language_id;
    }
}
