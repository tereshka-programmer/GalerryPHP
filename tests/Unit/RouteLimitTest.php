<?php

namespace Tests\Unit;

use App\Enum\Role;
use App\Models\Picture;
use App\Models\User;
use Tests\TestCase;

class RouteLimitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testAuthorRateLimit()
    {
//
        $user = User::where('role', '=', Role::Author->value)->first();
        $a = 0;
        while ($a < 401) {
            $response = $this->actingAs($user)
               ->get(route('home'));
            $a++;
        };
        $response->assertStatus(429);
    }

    public function testUserRateLimit()
    {
        $a = 0;
        while ($a < 101) {
            $response = $this->get(route('home'));
            $a++;
        };
        $response->assertStatus(429);
    }

    public function testReviewRateLimit()
    {
        $this->withoutJobs();

        $user = User::factory()->create();
        $picture = Picture::factory()->create([
            'status' => 'published'
        ]);
        $data = [
            'subject' => 'test Rate',
            'message' => 'test Rate',
        ];
        $a = 0;
        while ($a < 6) {
            $response = $this->actingAs($user)
                ->post(route('review.add', $picture), $data);
            $a++;
        }
        $response->assertStatus(429);
    }
}
