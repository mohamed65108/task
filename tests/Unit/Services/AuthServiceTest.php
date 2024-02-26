<?php

namespace Tests\Unit\Services;

use App\Services\AuthService;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    public function testExtractCompanyWithValidFOOLogin()
    {
        $service = new AuthService();
        $login = 'FOO_user123';

        $result = $service->extractCompany($login);

        $this->assertEquals('FOO', $result);
    }

    public function testExtractCompanyWithValidBARLogin()
    {
        $service = new AuthService();
        $login = 'BAR_user123';

        $result = $service->extractCompany($login);

        $this->assertEquals('BAR', $result);
    }

    public function testExtractCompanyWithValidBAZLogin()
    {
        $service = new AuthService();
        $login = 'BAZ_user123';

        $result = $service->extractCompany($login);

        $this->assertEquals('BAZ', $result);
    }

    public function testExtractCompanyWithInvalidLogin()
    {
        $service = new AuthService();
        $login = 'FOo_123';

        $result = $service->extractCompany($login);

        $this->assertNull($result);
    }

    public function testLoginWithValidFOOCredentials()
    {
        $service = new AuthService();
        $login = 'FOO_user123';
        $password = 'foo-bar-baz';

        $result = $service->login($login, $password);

        $this->assertTrue($result);
    }

    public function testLoginWithValidBARCredentials()
    {
        $service = new AuthService();
        $login = 'BAR_user123';
        $password = 'foo-bar-baz';

        $result = $service->login($login, $password);

        $this->assertTrue($result);
    }

    public function testLoginWithValidBAZCredentials()
    {
        $service = new AuthService();
        $login = 'BAZ_user123';
        $password = 'foo-bar-baz';

        $result = $service->login($login, $password);

        $this->assertTrue($result);
    }

    public function testLoginWithInvalidCredentials()
    {
        $service = new AuthService();
        $login = 'Foo_123';
        $password = 'foo-bar-baz';

        $result = $service->login($login, $password);

        $this->assertFalse($result);
    }
}

