<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make(UserService::class);
    }

    public function testUserService(){
        self::assertTrue(true);
    }

    public function testLoginSuccess(){
        self::assertTrue($this->userService->login("Fadhil", "firmansyah"));
    }

    public function testLoginNotFound(){
        self::assertFalse($this->userService->login("windah", "basudara"));
    }

    public function testLoginWrongPassword(){
        self::assertFalse($this->userService->login("Fadhil", "rahasia"));
    }
}
