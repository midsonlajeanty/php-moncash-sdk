<?php

declare(strict_types=1);

namespace Mds\Moncash\Core;

/**
 * PaymentStatus - Moncash payment statuses.
 */
final class PaymentStatus
{
    public const SUCCESSFUL = 'successful';

    public const FAILED = 'failed';

    public const PENDING = 'pending';
}
