<?php

namespace Tests\Feature\Controllers;

use App\Exceptions\MovieServiceUnavailableException;
use App\Services\MovieService;
use Mockery;
use Tests\TestCase;

class MovieControllerTest extends TestCase
{
    public function testGetTitlesSuccessfully()
    {
        // Mock the MovieService class
        $movieServiceMock = Mockery::mock(MovieService::class);
        $movieServiceMock->shouldReceive('getTitles')->once()->andReturn(['Title 1', 'Title 2']);

        // Replace the actual MovieService instance with the mock
        $this->app->instance(MovieService::class, $movieServiceMock);

        // Make a GET request to the endpoint
        $response = $this->get('/api/titles');

        // Assert the response status code is 200 (OK)
        $response->assertStatus(200);

        // Assert the response JSON contains the titles returned by the MovieService mock
        $response->assertJson(['Title 1', 'Title 2']);
    }

    public function testGetTitlesFailure()
    {
        // Mock the MovieService class to throw an exception
        $movieServiceMock = Mockery::mock(MovieService::class);
        $movieServiceMock->shouldReceive('getTitles')->once()->andThrow(MovieServiceUnavailableException::class);

        // Replace the actual MovieService instance with the mock
        $this->app->instance(MovieService::class, $movieServiceMock);

        // Make a GET request to the endpoint
        $response = $this->get('/api/titles');

        // Assert the response status code is 500 (Internal Server Error)
        $response->assertStatus(500);

        // Assert the response JSON contains the failure status
        $response->assertJson(['status' => 'failure']);
    }
}
