<?php

declare(strict_types=1);

namespace App\Model\Table\Exceptions;

use RuntimeException;
use Throwable;

/**
 * An exception that signals that data was required for the notification, but was missing.
 */
class MalformedDataException extends RuntimeException
{
    /**
     * Constructor
     *
     * @param string $message The exception message
     * @param int $code The exception code that will be used as a HTTP status code
     * @param Throwable|null $previous The previous exception or null
     */
    public function __construct(string $message = '', int $code = 500, ?Throwable $previous = null)
    {
        if (! $message) {
            $message = 'Data package is Malformed';
        }
        parent::__construct($message, $code, $previous);
    }
}
