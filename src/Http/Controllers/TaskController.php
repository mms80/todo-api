<?php

namespace mms80\TodoApi\Http\Controllers;

use mms80\TodoApi\Http\Requests\Task\ShowRequest;
use mms80\TodoApi\Http\Requests\Task\StoreRequest;
use mms80\TodoApi\Http\Requests\Task\UpdateRequest;
use mms80\TodoApi\Http\Resources\TaskAPIResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mms80\TodoApi\Task;
use mms80\TodoApi\Label;
use mms80\TodoApi\Notifications\Mail;
use Illuminate\Support\Facades\Notification;

class TaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return TaskAPIResource::collection($user->tasks);
    }

    public function store(StoreRequest $request)
    {
        $request->validated();
        $task = Task::create([
            'user_id' => Auth::user()->id,
            'title' => $request['title'],
            'description' => $request['description'],
            'status' => Task::OPEN,
        ]);
        if($request['labels']){
            $this->syncLabels($request,$task);
        }
        return new TaskAPIResource($task);
    }

    public function show(ShowRequest $request,Task $task)
    {
        $request->validated();
        return new TaskAPIResource($task);
    }

    public function update(UpdateRequest $request, Task $task)
    {
        $request->validated();
        $task->update([
            'title' => $request['title'] ? $request['title'] : $task->title,
            'description' => $request['description'] ? $request['description'] : $task->description,
            'status' => $request['status'] ? $request['status'] : $task->status,
        ]);
        if($request['status'] == Task::CLOSE){
            Notification::send(Auth::user(),new Mail($task));
        }
        if($request['labels']){
            $this->syncLabels($request,$task);
        }
        return new TaskAPIResource($task);
    }

    public function syncLabels(Request $request,Task $task){
        $labels = array_unique($request['labels']);
        $ids = [];
        foreach($labels as $label){
            $ids[] = Label::firstOrCreate([
                'title' => $label
            ])->id;
        }
        if($request['detaching']){
            $task->labels()->sync($ids);
        }else{
            $task->labels()->syncWithoutDetaching($ids);
        }
        return true;
    }
}
