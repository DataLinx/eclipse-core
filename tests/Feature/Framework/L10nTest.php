<?php

namespace Tests\Feature\Framework;

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Framework\L10n;
use Eclipse\Core\Models\User;
use Exception;

class L10nTest extends PackageTestCase
{
    /**
     * @var L10n
     */
    private $l10n;

    public function setUp(): void
    {
        parent::setUp();

        if (empty($this->l10n)) {
            $this->l10n = resolve(L10n::class);
        }

        $this->l10n->setLanguage('en');
        $this->l10n->setLanguageValidation(true);
        $this->l10n->setDomain('core');
    }

    public function test_domain_can_be_bound()
    {
        // Test with set_domain
        $this->l10n->setDomain('core');
        $this->assertEquals('core', textdomain(null));
        $this->l10n->bindDomain('test', __DIR__.'/../../../resources/locales', true);
        $this->assertEquals('test', textdomain(null));
    }

    public function test_non_existing_domain_can_be_detected()
    {
        $dir = 'some/dir';
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Directory $dir does not exist");
        $this->l10n->bindDomain('test123', $dir);
    }

    public function test_empty_domain_can_be_detected()
    {
        // Test empty domain
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Domain parameter is required');
        $this->l10n->setDomain('');
    }

    public function test_tmp_domain_can_be_set()
    {
        $this->l10n->bindDomain('test', __DIR__.'/../../../resources/locales');

        // Initial state
        $this->l10n->setDomain('core');
        $this->assertEquals('core', textdomain(null));

        // Set tmp
        $this->l10n->setDomain('test', true);
        $this->assertEquals('test', textdomain(null));

        // Reset
        $this->l10n->resetDomain();
        $this->assertEquals('core', textdomain(null));

        // Unneeded reset
        $this->l10n->resetDomain();
        $this->assertEquals('core', textdomain(null));
    }

    public function test_invalid_language_can_be_detected()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('"bla" is not a valid UI language');
        $this->l10n->setLanguage('bla');
    }

    public function test_invalid_data_language_can_be_detected()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('"hr" is not a valid data language');
        $this->l10n->setLanguage('en', 'hr');
    }

    public function test_language_can_be_set()
    {
        $this->l10n->setLanguage('en', 'sl');
        $this->assertEquals('en', $this->l10n->getLanguageId());
        $this->assertEquals('sl', $this->l10n->getDataLanguageId());
    }

    public function test_language_validation_can_be_disabled()
    {
        $this->l10n->setLanguageValidation(false);
        $this->l10n->setLanguage('hr');
        $this->assertEquals('hr', $this->l10n->getLanguageId());
    }

    public function test_sl_language_can_be_set_from_cookie()
    {
        $this->actingAs(User::factory()->make())
            ->withUnencryptedCookie(L10n::COOKIE_NAME, 'sl');

        $response = $this->get('/dashboard');

        $response->assertSee('html lang="sl"', false);
    }

    public function test_en_language_can_be_set_from_cookie()
    {
        $this->actingAs(User::factory()->make())
            ->withUnencryptedCookie(L10n::COOKIE_NAME, 'en');

        $response = $this->get('/dashboard');

        $response->assertSee('html lang="en"', false);
    }

    public function test_language_can_be_set_from_first_header_value()
    {
        $this->actingAs(User::factory()->make())
            ->withHeader('HTTP_ACCEPT_LANGUAGE', 'sl,en');

        $response = $this->get('/dashboard');

        $response->assertSee('html lang="sl"', false);
    }

    public function test_language_can_be_set_from_non_first_header_value()
    {
        $this->actingAs(User::factory()->make())
            ->withHeader('HTTP_ACCEPT_LANGUAGE', 'ru,en');

        $response = $this->get('/dashboard');

        $response->assertSee('html lang="en"', false);
    }

    public function test_invalid_language_in_header_can_be_handled()
    {
        $this->actingAs(User::factory()->make())
            ->withHeader('HTTP_ACCEPT_LANGUAGE', 'ru');

        $response = $this->get('/dashboard');

        $response->assertSee('html lang="en"', false);
    }
}
