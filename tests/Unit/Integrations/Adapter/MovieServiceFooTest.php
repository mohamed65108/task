<?php

namespace Tests\Unit\Integrations\Adapter;

use App\Exceptions\MovieServiceUnavailableException;
use App\Integrations\Adapter\MovieServiceFoo;
use External\Foo\Exceptions\ServiceUnavailableException;
use External\Foo\Movies\MovieService;
use PHPUnit\Framework\TestCase;

class MovieServiceFooTest extends TestCase
{
    public function testGetTitlesSuccess()
    {
        // Mock MovieService
        $movieServiceMock = $this->createMock(MovieService::class);
        $movieServiceMock->method('getTitles')->willReturn([
            'Title 1',
            'Title 2',
            'Title 3'
        ]);

        // Create MovieServiceFoo instance with mocked MovieService
        $adapter = new MovieServiceFoo($movieServiceMock);

        // Test the getTitles method
        $titles = $adapter->getTitles();

        // Assert that the method returns the expected titles
        $this->assertEquals(['Title 1', 'Title 2', 'Title 3'], $titles);
    }

    public function testGetTitlesThrowsException()
    {
        // Mock MovieService
        $movieServiceMock = $this->createMock(MovieService::class);
        $movieServiceMock->method('getTitles')->willThrowException(new ServiceUnavailableException());

        // Create MovieServiceFoo instance with mocked MovieService
        $adapter = new MovieServiceFoo($movieServiceMock);

        // Test that the getTitles method throws the expected exception
        $this->expectException(MovieServiceUnavailableException::class);
        $adapter->getTitles();
    }
}
