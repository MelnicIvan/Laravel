<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return view('tasks.index');
    }
    public function create()
    {
        return view('tasks.create');
    }
    public function store(Request $request)
    {
        return 'destroy';
    }
    public function show($id)
    {
        return view('tasks.show', ['id' => $id]);
    }
    public function edit($id)
    {
        return view('tasks.edit', ['id' => $id]);
    }
    public function update(Request $request, $id)
    {
        return $id + "update";
    }
    public function destroy($id)
    {
        return 'destroy' + $id;
    }
}
