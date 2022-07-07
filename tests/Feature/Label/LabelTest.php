<?php

namespace mms80\TodoApi\Tests\Feature\Label;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use mms80\TodoApi\Tests\TestCase;
use mms80\TodoApi\Label;
use mms80\TodoApi\User;

class LabelTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testShowAllLabels()
    {
        $user = factory(User::class)->create();
        $labels = factory(Label::class,10)->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$user->token
        ])
        ->json('GET','/labels/');
        $response->assertJsonStructure([
            'data' => [['id','title','total']]
        ]);
        $response->assertSuccessful();
    }

    public function testShowAllLabelsWithoutAuth()
    {
        $labels = factory(Label::class,10)->create();
        $response = $this->json('GET','/labels/');
        
        $response->assertUnauthorized();
    }

    public function testCreatLabel()
    {
        $user = factory(User::class)->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$user->token
        ])
        ->json('POST','/labels/',[
            'title' => "label1"
        ]);
        $response->assertJsonStructure([
            'data' => ['id','title','total']
        ]);
        $response->assertSuccessful();
    }

    public function testCreatLabelWithoutAuth()
    {
        $response = $this->json('POST','/labels/',[
            'title' => "label1"
        ]);
    
        $response->assertUnauthorized();
    }

    public function testCreatDuplicateLabel()
    {
        $user = factory(User::class)->create();
        $label = Label::create([
            'title' => 'label1'
        ]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$user->token
        ])
        ->json('POST','/labels/',[
            'title' => "label1"
        ]);
        
        $response->assertJsonValidationErrors('title');
    }
}
