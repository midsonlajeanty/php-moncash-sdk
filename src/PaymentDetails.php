<?php

declare(strict_types=1);
use Mds\Moncash\TransactionDetails;

// Compatibility bridge: loads TransactionDetails, which defines the Mds\Moncash\PaymentDetails alias.
// @deprecated Use Mds\Moncash\TransactionDetails instead.
class_exists(TransactionDetails::class);
