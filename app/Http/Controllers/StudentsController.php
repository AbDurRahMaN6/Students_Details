<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use domain\Facades\StudentsFacade;


class StudentsController extends Controller
{

    public function index(){
        return Inertia::render('Students');
    }

    public function store(Request $request) {
        return StudentsFacade::store($request->all());
    }
    public function list() {
        $tasks = StudentsFacade::all();
        return response()->json($tasks);
    }

    public function delete($task_id){
        return StudentsFacade::delete($task_id);
    }

    
    public function edit(Request $request){
        $response ['task'] = StudentsFacade:: get($request['task_id']);
        return view('pages.students.edit')->with($response);
    }

    public function active($task_id){
        return StudentsFacade::active($task_id);
    }

    public function update(Request $request, $task_id) {
        StudentsFacade::update($request ->all(),$task_id);
        return redirect()->back();
    }
    
}
