<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateStatusTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;
    /**@test*/
    function guests_users_can_not_create_statuses()
    {
        //$this->withExceptionHandling();

        $response =  $this->post(route('statuses.store'),['body'=>'Mi primer status']);

        //dd($response->content());

        $response->assertRedirect('login');

    }

    /** @test */
    public function an_athenticated_user_can_create_statuses()
    {
        //z$this->withExceptionHandling();
        // 1. Given => Teniendo un usuario autenticado
            $user = factory(User::class)->create();
            $this->actingAs($user);
        // 2. When => Cuando hace un post request a status
           $response =  $this->postJson(route('statuses.store'),['body'=>'Mi primer status']);

           //$response->assertSuccessful();
            $response->assertJson([
                'data'=>['body' =>'Mi primer status'],
            ]);

        // 3. Then => Entonces veo un nuevo estado en la base de datos
            $this->assertDatabaseHas('statuses',[
                'user_id' => $user->id,
                'body' => 'Mi primer status'
            ]);


    }

    /** @test */
    public function a_status_requires_a_body()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response =  $this->postJson(route('statuses.store'),['body'=>'']);

        //dd($response->getContent());
        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }

    /** @test */
    public function a_status_body_requires_a_minimum_length()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response =  $this->postJson(route('statuses.store'),['body'=>'asdf']);

        //dd($response->getContent());
        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);
    }
}
