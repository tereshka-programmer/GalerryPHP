<?php

namespace Tests\Unit;

use App\Models\Picture;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PictureTest extends TestCase
{
//    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testAddPicture()
    {
        $this->withoutJobs();
        $user = User::factory()->create();

        $data = [
          'title' => 'Title',
          'description' => 'description Test',
          'user_file' => UploadedFile::fake()->image('avatar.jpg'),
        ];

        $response = $this->actingAs($user)
            ->post(route('picture.create'), $data);

        $this->assertDatabaseHas('pictures', [
            'title'=>'Title',
            'description'=> 'description Test'
        ]);
    }

    public function testEditPictureNewImage()
    {
        $this->withoutJobs();
        $this->withoutMiddleware();

        $user = User::factory()
            ->hasPictures(1)
            ->create();

        $picture = Picture::where('user_id', $user->id)->get();

        $data = [
            'title' => 'Test edit title',
            'description'  => 'Test edit Description',
            'user_file' => UploadedFile::fake()->image('avatar.jpg'),

        ];

        $response = $this->actingAs($user)
            ->put(route('picture.update', $picture->first()), $data);

        $this->assertDatabaseHas('pictures', [
            'title'=>'Test edit title',
            'description'=>'Test edit Description'
        ]);
    }

    public function testEditPictureWithoutNewImage()
    {
        $this->withoutJobs();
        $this->withoutMiddleware();

        $user = User::factory()
            ->hasPictures(1)
            ->create();

        $picture = Picture::where('user_id', $user->id)->get();

        $data = [
            'title' => 'Test edit title',
            'description'  => 'Test edit Description',
            'user_file' => ''

        ];

        $response = $this->actingAs($user)
            ->put(route('picture.update', $picture->first()), $data);

        $this->assertDatabaseHas('pictures', [
            'title'=>'Test edit title',
            'description'=>'Test edit Description'
        ]);
    }
}
