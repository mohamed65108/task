<?php

namespace App\Traits;

use Exception;

trait Retryable
{
    /**
     * Execute a closure or method with exception handling and retry mechanism.
     *
     * @param callable $callable The closure or method to execute.
     * @param int $maxAttempts The maximum number of attempts.
     * @param int $delay The delay between attempts in seconds.
     * @return mixed The result of the closure or method.
     * @throws Exception If the callable fails after the maximum number of attempts.
     */
    protected function retry(callable $callable, int $maxAttempts = 3, int $delay = 2): mixed
    {
        for ($attempts = 1; $attempts <= $maxAttempts; $attempts++) {
            try {
                return $callable();
            } catch (Exception) {
                if ($attempts !== $maxAttempts) {
                    sleep($delay);
                }
            }
        }
        throw new Exception();
    }
}
