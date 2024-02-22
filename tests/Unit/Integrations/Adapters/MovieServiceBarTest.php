<?php

namespace Tests\Unit\Integrations\Adapters;

use App\Exceptions\MovieServiceUnavailableException;
use App\Integrations\Adapters\MovieServiceBar;
use External\Bar\Exceptions\ServiceUnavailableException;
use External\Bar\Movies\MovieService;
use PHPUnit\Framework\TestCase;

class MovieServiceBarTest extends TestCase
{
    public function testGetTitlesSuccess()
    {
        // Mock MovieService
        $movieServiceMock = $this->createMock(MovieService::class);
        $movieServiceMock->method('getTitles')->willReturn([
            'titles' => [
                ['title' => 'Title 1', 'summary' => 'Summary 1'],
                ['title' => 'Title 2', 'summary' => 'Summary 2'],
            ]
        ]);

        // Create MovieServiceBar instance with mocked MovieService
        $adapter = new MovieServiceBar($movieServiceMock);

        // Test the getTitles method
        $titles = $adapter->getTitles();

        // Assert that the method returns the expected titles
        $this->assertEquals(['Title 1', 'Title 2'], $titles);
    }

    public function testGetTitlesThrowsException()
    {
        // Mock MovieService
        $movieServiceMock = $this->createMock(MovieService::class);
        $movieServiceMock->method('getTitles')->willThrowException(new ServiceUnavailableException());

        // Create MovieServiceBar instance with mocked MovieService
        $adapter = new MovieServiceBar($movieServiceMock);

        // Test that the getTitles method throws the expected exception
        $this->expectException(MovieServiceUnavailableException::class);
        $adapter->getTitles();
    }
}
