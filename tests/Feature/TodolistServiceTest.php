<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolistServiceNotNull(){
        self::assertNotNull($this->todolistService);
    }

    public function testTodolistSave(){
        $this->todolistService->saveTodo("1", "Cuci piring");

        $sessions = Session::get("todolist");
        foreach($sessions as $session){
            self::assertEquals("1", $session["id"]);
            self::assertEquals("Cuci piring", $session["todo"]);
        }
    }

    public function testTodolistGetEmpty(){
        self::assertEquals([], $this->todolistService->getTodolist());
    }

    public function testTodolistGetValue(){
        $exp = [
            [
                "id" => "1",
                "todo" => "Cuci motor"
            ],
            [
                "id" => "2",
                "todo" => "Pergi Lembang"
            ]
        ];

        $this->todolistService->saveTodo("1", "Cuci motor");
        $this->todolistService->saveTodo("2", "Pergi Lembang");

        self::assertEquals($exp, $this->todolistService->getTodolist());
    }

    public function testRemoveTodo(){
        $this->todolistService->saveTodo("1", "Beli baju");
        $this->todolistService->saveTodo("2", "Beli mouse");

        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));
        
        $this->todolistService->removeTodo("3");
        self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo("2");
        self::assertEquals(1, sizeof($this->todolistService->getTodolist()));

        $this->todolistService->removeTodo("1");
        self::assertEquals(0, sizeof($this->todolistService->getTodolist()));
    }
}
