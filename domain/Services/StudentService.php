<?php


namespace domain\Services;

use App\Models\SubTask;
use App\Models\Students;

class StudentService
{
    protected $task;

    public function __construct()
    {
        $this->task = new Students();
    }

    public function get($task_id) {
        return $this->task->find($task_id);
    }
    public function all()
    {
        return $this->task->all();
    }
    public function store($data)
    {
        $this->task->create($data);
    }
    public function delete($task_id)
    {
        $task = $this->task->find($task_id);
        $task->delete();
    }
    public function active($task_id)
    {
        $task = $this->task->find($task_id);
        if($task->active == 1){
            $task->done = 0;
        }
        else{
            $task->done = 1;
        }
        
        $task->update();
    }
    public function edit($task_id)
    {
        return array_merge($task->toArray(), $data);
    }

    public function update(array $data, $task_id){
        $task = $this->task->find($task_id);
        $task->update($this->edit($task, $data));
    }
    
}