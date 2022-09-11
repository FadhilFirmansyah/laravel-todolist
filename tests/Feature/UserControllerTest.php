<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLogin(){
        $this->get("/login")
        ->assertSeeText("Login")
        ->assertSeeText("DHIL")
        ->assertSeeText("Sign In");
    }

    public function testGetLoginMiddleware(){
        $this->withSession([
            "user" => "Fadhil"
        ])->get("/login")
        ->assertRedirect("/");
    }

    public function testPostLoginMiddleware(){
        $this->withSession([
            "user" => "Fadhil"
        ])->post("/login", [
            "user" => "Fadhil",
            "password" => "firmansyah"
        ])->assertRedirect("/");
    }

    public function testLoginSuccess(){
        $this->post("/login", [
            "user" => "Fadhil",
            "password" => "firmansyah"
        ])->assertSessionHas("user", "Fadhil")
        ->assertRedirect("/");
    }

    public function testLoginNullElement(){
        $this->post("/login", [])
        ->assertSeeText("Username and Password is required");
    }

    public function testLoginErrorPassword(){
        $this->post("/login", [
            "user" => "joko",
            "password" => "firmansyah"
        ])->assertSeeText("Username or Password is wrong");
    }

    public function testLogout(){
        $this->withSession([
            "user" => "Fadhil"
        ])->post("/logout")
        ->assertRedirect("/")
        ->assertSessionMissing("user");
    }

    public function testLogoutMiddleware(){
        $this->post("/logout")
        ->assertRedirect("/");
    }
}
