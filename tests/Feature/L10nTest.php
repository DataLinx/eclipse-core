<?php

namespace Ocelot\Core\Tests\Feature;

use Exception;
use Ocelot\Core\Framework\L10n;
use Ocelot\Core\Models\User;
use Ocelot\Core\Testing\PackageTestCase;

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

    public function testBindDomain()
    {
        // Test with set_domain
        $this->l10n->setDomain('core');
        $this->assertEquals('core', textdomain(NULL));
        $this->l10n->bindDomain('test', package_path('ocelot/core', 'resources/locales'), true);
        $this->assertEquals('test', textdomain(NULL));

        // Test non-existing domain
        $dir = 'some/dir';
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Directory $dir does not exist");
        $this->l10n->bindDomain('test123', $dir);
    }

    public function testSetDomain()
    {
        // Test empty domain
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Domain parameter is required');
        $this->l10n->setDomain('');
    }

    public function testSetTmpDomain()
    {
        $this->l10n->bindDomain('test', package_path('ocelot/core', 'resources/locales'));

        // Initial state
        $this->l10n->setDomain('core');
        $this->assertEquals('core', textdomain(NULL));

        // Set tmp
        $this->l10n->setDomain('test', true);
        $this->assertEquals('test', textdomain(NULL));

        // Reset
        $this->l10n->resetDomain();
        $this->assertEquals('core', textdomain(NULL));

        // Unneeded reset
        $this->l10n->resetDomain();
        $this->assertEquals('core', textdomain(NULL));
    }

    public function testSetInvalidLanguage()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('"bla" is not a valid UI language');
        $this->l10n->setLanguage('bla');
    }

    public function testSetInvalidDataLanguage()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('"hr" is not a valid data language');
        $this->l10n->setLanguage('en', 'hr');
    }

    public function testSetLanguage()
    {
        $this->l10n->setLanguage('en', 'sl');
        $this->assertEquals('en', $this->l10n->getLanguageId());
        $this->assertEquals('sl', $this->l10n->getDataLanguageId());
    }

    public function testNoValidationLanguage()
    {
        $this->l10n->setLanguageValidation(false);
        $this->l10n->setLanguage('hr');
        $this->assertEquals('hr', $this->l10n->getLanguageId());
    }

    public function testDetectLanguageFromCookieSl()
    {
        $this->actingAs(User::factory()->make())
             ->withUnencryptedCookie(L10n::COOKIE_NAME, 'sl');

        $response = $this->get('/dashboard');

        $response->assertSee('html lang="sl"', false);
    }

    public function testDetectLanguageFromCookieEn()
    {
        $this->actingAs(User::factory()->make())
             ->withUnencryptedCookie(L10n::COOKIE_NAME, 'en');

        $response = $this->get('/dashboard');

        $response->assertSee('html lang="en"', false);
    }

    public function testDetectLanguageFromHeaderFirst()
    {
        $this->actingAs(User::factory()->make())
             ->withHeader('HTTP_ACCEPT_LANGUAGE', 'sl,en');

        $response = $this->get('/dashboard');

        $response->assertSee('html lang="sl"', false);
    }

    public function testDetectLanguageFromHeaderNonFirst()
    {
        $this->actingAs(User::factory()->make())
             ->withHeader('HTTP_ACCEPT_LANGUAGE', 'ru,en');

        $response = $this->get('/dashboard');

        $response->assertSee('html lang="en"', false);
    }

    public function testDetectLanguageFromHeaderInvalid()
    {
        $this->actingAs(User::factory()->make())
             ->withHeader('HTTP_ACCEPT_LANGUAGE', 'ru');

        $response = $this->get('/dashboard');

        $response->assertSee('html lang="en"', false);
    }
}
