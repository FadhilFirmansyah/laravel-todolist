<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testGetTodolist(){
        $this->withSession([
            "user" => "Fadhil",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Makan"
                ],
                [
                    "id" => "2",
                    "todo" => "Ibadah"
                ]
            ]
        ])->get("/todolist")
        ->assertSeeText("1")->assertSeeText("Makan")
        ->assertSeeText("2")->assertSeeText("Ibadah");
    }

    public function testSaveTodoError(){
        $this->withSession([
            "user" => "Fadhil"
        ])->post('/todolist')->assertSeeText("Todo musn't be empty");
    }

    public function testSaveTodolistSuccess(){
        $this->withSession([
            "user" => "Fadhil"
        ])->post("/todolist", [
            "id" => "1",
            "todo" => "game"
        ])->assertRedirect("/todolist");
    }

    public function testRemoveTodolistSuccess(){
        $this->withSession([
            "user" => "Fadhil",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Makan"
                ],
                [
                    "id" => "2",
                    "todo" => "Ibadah"
                ]
            ]
        ])->post("/todolist/2/delete")->assertRedirect("/todolist");
    }
}
