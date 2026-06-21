<?php

declare(strict_types=1);

// Compatibility bridge: loads TransactionDetails, which defines the Mds\Moncash\PaymentDetails alias.
// @deprecated Use Mds\Moncash\TransactionDetails instead.
class_exists(\Mds\Moncash\TransactionDetails::class);
