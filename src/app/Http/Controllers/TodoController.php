<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Http\Requests\TodoRequest;
//use Illuminate\Http\Request;

class TodoController extends Controller
{
    private $todo; 

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }
    public function index()
    {
        $todos = $this->todo->all();

        return view('todo.index', ['todos' => $todos]);
    }
    public function create()
    {
        return view('create');
    }

    public function store(TodoRequest $request)
    {
        $inputs = $request->all();
        
        $todo = new Todo();
        $this->todo->fill($inputs);
        $this->todo->save();
        return redirect()->route('todo.index');
    }
    public function show($id)
    {
        $todo = $this->todo->find($id); 
        return view('todo.show', ['todo' => $todo]);
    }
    public function edit($id)
    {
        $todo = $this->todo->find($id); 
        return view('todo.edit', ['todo' => $todo]); 
    }

    public function update(TodoRequest $request, $id) // 第1引数: リクエスト情報の取得　第2引数: ルートパラメータの取得
    {
        // TODO: リクエストされた値を取得
        $inputs = $request->all();
        $todo = $this->todo->find($id);
        $todo->fill($inputs);
        $todo->save();
        return redirect()->route('todo.show', $todo->id);
    }
    public function delete($id)
    {
        $todo =  $this->todo->find($id);
        $todo->delete();
        return redirect()->route('todo.index');
    }
}

