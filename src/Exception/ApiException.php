<?php

declare(strict_types=1);

namespace Mds\Moncash\Exception;

/**
 * Thrown when the Moncash API returns an error (non-success response or HTTP error).
 */
class ApiException extends MoncashException {}
