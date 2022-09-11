<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodolistController extends Controller
{
    public function __construct(private TodolistService $todolistService)
    {
        
    }

    public function todoList(Request $request):Response{
        return response()->view("todolist.todolist", [
            "title" => "Todolist",
            "todolist" => $this->todolistService->getTodolist()
        ]);
    }

    public function addTodo(Request $request):Response|RedirectResponse{
        $todo = $request->input("todo");

        if(empty($todo)){
            return response()->view("todolist.todolist", [
                "title" => "Todolist",
                "todolist" => $this->todolistService->getTodolist(),
                "error" => "Todo musn't be empty"
            ]);
        }

        $this->todolistService->saveTodo(uniqid(), $todo);

        return redirect()->action([TodolistController::class, "todoList"]);
    }

    public function removeTodo(Request $request, string $todoId):RedirectResponse{
        $this->todolistService->removeTodo($todoId);
        
        return redirect()->action([TodolistController::class, "todoList"]);
    }
}
