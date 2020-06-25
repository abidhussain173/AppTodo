<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;
use MongoDB\Driver\Session;

class TodosController extends Controller
{
    public function index()
    {
        $todos = Todo::all();


        return view('index',compact('todos'));
    }
    public function show(Todo $todo)
    {
       return view('show')->with('todo',$todo);
    }
    public function create()
    {
        return view('create');
    }

    public function store()
    {
        $this->validate(request(),
            [
                'name' => 'required|min:6|max:12',
                'description' => 'required'

            ]);



      $data = request()->all();
      $todo = new Todo();

      $todo->name = $data['name'];
      $todo->description = $data['description'];
      $todo->completed = false;

      $todo->save();

      Session()->flash('success' , 'Todo created successfully.');

      return redirect('/todos');

    }


    public function edit(Todo $todo)
    {

        return view('edit')->with('todo', $todo);
    }

    public function update(Todo $todo)
    {
        $this->validate(request(),
            [
                'name' => 'required|min:6|max:12',
                'description' => 'required'

            ]);
        $data = request()->all();

        $todo->name = $data['name'];
        $todo->description = $data['description'];


        $todo->save();

        Session()->flash('success' , 'Todo updated successfully.');

        return redirect('/todos');
    }

    public function destroy(Todo $todo)
    {

        $todo->delete();

        Session()->flash('success' , 'Todo deleted successfully.');

        return redirect('/todos');
    }

    public function complete(Todo $todo)
    {
        $todo->completed == true ;


            $todo->save();

        Session()->flash('success', 'Todo completed successfully');

        return redirect('/todos');

    }

}
