<?php

namespace mms80\TodoApi\Tests\Feature\Task;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use mms80\TodoApi\User;
use mms80\TodoApi\Task;
use mms80\TodoApi\Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateTask()
    {
        $user = factory(User::class)->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$user->token
        ])
        ->json('POST','/api/tasks',[
            'title' => 'task1',
            'description' => 'task1',
        ]);

        $response->assertJsonStructure([
            'data' => ['id','title','description','status','labels'=>[]]
        ]);
        $response->assertSuccessful();
    }

    public function testCreateTaskWithLabel()
    {
        $user = factory(User::class)->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$user->token
        ])
        ->json('POST','/api/tasks',[
            'title' => 'task1',
            'description' => 'task1',
            'labels'=>['label1','label2','label2'],
        ]);
        $response->assertJsonStructure([
            'data' => ['id','title','description','status','labels'=>[['id','title','total']]]
        ]);
        $response->assertSuccessful();
    }

    public function testUpdateTask()
    {
        $user = factory(User::class)->create();
        $task = factory(Task::class)->make()->toArray();
        $task['user_id'] = $user->id;
        $task = Task::create($task);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$user->token
        ])
        ->json('PUT','/api/tasks/'.$task->id,[
            'title' => 'task1',
            'description' => 'task1',
            'status' => 2
        ]);

        $response->assertJsonStructure([
            'data' => ['id','title','description','status','labels'=>[]]
        ]);
        $response->assertSuccessful();
    }

    public function testUpdateTaskWithLabel()
    {
        $user = factory(User::class)->create();
        $task = factory(Task::class)->make()->toArray();
        $task['user_id'] = $user->id;
        $task = Task::create($task);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$user->token
        ])
        ->json('PUT','/api/tasks/'.$task->id,[
            'title' => 'task1',
            'description' => 'task1',
            'status' => 2,
            'labels' => ["label1","label2"]
        ]);
        $response->assertJsonStructure([
            'data' => ['id','title','description','status','labels'=>[['id','title','total']]]
        ]);
        $response->assertSuccessful();
    }

    public function testUpdateTaskWithoutAuth()
    {
        $user = factory(User::class)->create();
        $task = factory(Task::class)->make()->toArray();
        $task = Task::create($task);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$user->token
        ])
        ->json('PUT','/api/tasks/'.$task->id,[
            'title' => 'task1',
            'description' => 'task1',
            'status' => 2
        ]);

        $response->assertForbidden();
    }

    public function testShowTask()
    {
        $user = factory(User::class)->create();
        $task = factory(Task::class)->make()->toArray();
        $task['user_id'] = $user->id;
        $task = Task::create($task);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$user->token
        ])
        ->json('GET','/api/tasks/'.$task->id);
        $response->assertJsonStructure([
            'data' => ['id','title','description','status','labels'=>[]]
        ]);
        $response->assertSuccessful();
    }

    public function testShowTaskWithoutAuth()
    {
        $user = factory(User::class)->create();
        $task = factory(Task::class)->make()->toArray();
        $task = Task::create($task);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$user->token
        ])
        ->json('GET','/api/tasks/'.$task->id);
        
        $response->assertForbidden();
    }

    public function testShowAllTasks()
    {
        $user = factory(User::class)->create();
        $task = factory(Task::class)->make()->toArray();
        $task['user_id'] = $user->id;
        $task = Task::create($task);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$user->token
        ])
        ->json('GET','/api/tasks/');

        $response->assertJsonStructure([
            'data' => [['id','title','description','status','labels'=>[]]]
        ]);
        $response->assertSuccessful();
    }

    public function testShowAllTasksWithoutAuth()
    {
        $user = factory(User::class)->create();
        $task = factory(Task::class)->make()->toArray();
        $task['user_id'] = $user->id;
        $task = Task::create($task);
        $response = $this->json('GET','/api/tasks/');

        $response->assertUnauthorized();
    }
    

}
