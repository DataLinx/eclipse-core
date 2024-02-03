<?php

use Eclipse\Core\Framework\L10n;
use Eclipse\Core\Models\User;

beforeEach(function () {
    if (empty($this->l10n)) {
        $this->l10n = resolve(L10n::class);
    }

    $this->l10n->setLanguage('en');
    $this->l10n->setLanguageValidation(true);
    $this->l10n->setDomain('core');
});

test('domain can be bound', function () {
    // Test with set_domain
    $this->l10n->setDomain('core');
    expect(textdomain(null))->toEqual('core');
    $this->l10n->bindDomain('test', __DIR__.'/../../../resources/locales', true);
    expect(textdomain(null))->toEqual('test');
});

test('non existing domain can be detected', function () {
    $dir = 'some/dir';
    $this->expectException(Exception::class);
    $this->expectExceptionMessage("Directory $dir does not exist");
    $this->l10n->bindDomain('test123', $dir);
});

test('empty domain can be detected', function () {
    // Test empty domain
    $this->expectException(Exception::class);
    $this->expectExceptionMessage('Domain parameter is required');
    $this->l10n->setDomain('');
});

test('tmp domain can be set', function () {
    $this->l10n->bindDomain('test', __DIR__.'/../../../resources/locales');

    // Initial state
    $this->l10n->setDomain('core');
    expect(textdomain(null))->toEqual('core');

    // Set tmp
    $this->l10n->setDomain('test', true);
    expect(textdomain(null))->toEqual('test');

    // Reset
    $this->l10n->resetDomain();
    expect(textdomain(null))->toEqual('core');

    // Unneeded reset
    $this->l10n->resetDomain();
    expect(textdomain(null))->toEqual('core');
});

test('invalid language can be detected', function () {
    $this->expectException(Exception::class);
    $this->expectExceptionMessage('"bla" is not a valid UI language');
    $this->l10n->setLanguage('bla');
});

test('invalid data language can be detected', function () {
    $this->expectException(Exception::class);
    $this->expectExceptionMessage('"hr" is not a valid data language');
    $this->l10n->setLanguage('en', 'hr');
});

test('language can be set', function () {
    $this->l10n->setLanguage('en', 'sl');
    expect($this->l10n->getLanguageId())->toEqual('en');
    expect($this->l10n->getDataLanguageId())->toEqual('sl');
});

test('language validation can be disabled', function () {
    $this->l10n->setLanguageValidation(false);
    $this->l10n->setLanguage('hr');
    expect($this->l10n->getLanguageId())->toEqual('hr');
});

test('sl language can be set from cookie', function () {
    $this->actingAs(User::factory()->make())
        ->withUnencryptedCookie(L10n::COOKIE_NAME, 'sl');

    $response = $this->get('/dashboard');

    $response->assertSee('html lang="sl"', false);
});

test('en language can be set from cookie', function () {
    $this->actingAs(User::factory()->make())
        ->withUnencryptedCookie(L10n::COOKIE_NAME, 'en');

    $response = $this->get('/dashboard');

    $response->assertSee('html lang="en"', false);
});

test('language can be set from first header value', function () {
    $this->actingAs(User::factory()->make())
        ->withHeader('HTTP_ACCEPT_LANGUAGE', 'sl,en');

    $response = $this->get('/dashboard');

    $response->assertSee('html lang="sl"', false);
});

test('language can be set from non first header value', function () {
    $this->actingAs(User::factory()->make())
        ->withHeader('HTTP_ACCEPT_LANGUAGE', 'ru,en');

    $response = $this->get('/dashboard');

    $response->assertSee('html lang="en"', false);
});

test('invalid language in header can be handled', function () {
    $this->actingAs(User::factory()->make())
        ->withHeader('HTTP_ACCEPT_LANGUAGE', 'ru');

    $response = $this->get('/dashboard');

    $response->assertSee('html lang="en"', false);
});
