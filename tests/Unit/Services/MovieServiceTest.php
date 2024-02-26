<?php

namespace Tests\Unit\Services;

use App\Integrations\Bar\Adapters\Movie\MovieServiceBar;
use App\Integrations\Baz\Adapters\Movie\MovieServiceBaz;
use App\Integrations\Foo\Adapters\Movie\MovieServiceFoo;
use App\Services\MovieService;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class MovieServiceTest extends TestCase
{
    public function testGetTitles()
    {
        // Mock the movie service adapters
        $movieServiceFooMock = $this->createMock(MovieServiceFoo::class);
        $movieServiceBarMock = $this->createMock(MovieServiceBar::class);
        $movieServiceBazMock = $this->createMock(MovieServiceBaz::class);

        $movieServiceFooMock->expects($this->once())->method('getTitles')->willReturn(['Foo Title 1', 'Foo Title 2']);
        $movieServiceBarMock->expects($this->once())->method('getTitles')->willReturn(['Bar Title 1', 'Bar Title 2']);
        $movieServiceBazMock->expects($this->once())->method('getTitles')->willReturn(['Baz Title 1', 'Baz Title 2']);

        // Replace the service instances in the container with mocks
        $this->app->instance(MovieServiceFoo::class, $movieServiceFooMock);
        $this->app->instance(MovieServiceBar::class, $movieServiceBarMock);
        $this->app->instance(MovieServiceBaz::class, $movieServiceBazMock);

        // Mock the cache facade
        Cache::shouldReceive('has')->times(3)->andReturn(false);
        Cache::shouldReceive('put')->times(3);

        // Create an instance of the MovieService class
        $movieService = $this->app->make(MovieService::class);

        // Call the getTitles() method
        $titles = $movieService->getTitles();

        // Assert that the result is an array containing titles from all three services
        $this->assertEquals(['Foo Title 1', 'Foo Title 2', 'Bar Title 1', 'Bar Title 2', 'Baz Title 1', 'Baz Title 2'], $titles);
    }
}

