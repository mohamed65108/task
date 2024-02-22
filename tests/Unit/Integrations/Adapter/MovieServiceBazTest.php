<?php

namespace Tests\Unit\Integrations\Adapter;

use App\Exceptions\MovieServiceUnavailableException;
use App\Integrations\Adapter\MovieServiceBaz;
use External\Baz\Exceptions\ServiceUnavailableException;
use External\Baz\Movies\MovieService;
use PHPUnit\Framework\TestCase;

class MovieServiceBazTest extends TestCase
{
    public function testGetTitlesSuccess()
    {
        // Mock MovieService
        $movieServiceMock = $this->createMock(MovieService::class);
        $movieServiceMock->method('getTitles')->willReturn([
            'titles' => ['Title 1', 'Title 2', 'Title 3']
        ]);

        // Create MovieServiceBaz instance with mocked MovieService
        $adapter = new MovieServiceBaz($movieServiceMock);

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

        // Create MovieServiceBaz instance with mocked MovieService
        $adapter = new MovieServiceBaz($movieServiceMock);

        // Test that the getTitles method throws the expected exception
        $this->expectException(MovieServiceUnavailableException::class);
        $adapter->getTitles();
    }
}
