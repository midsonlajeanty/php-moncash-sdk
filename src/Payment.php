<?php

declare(strict_types=1);

// Compatibility bridge: loads PaymentResponse, which defines the Mds\Moncash\Payment alias.
// @deprecated Use Mds\Moncash\PaymentResponse instead.
class_exists(\Mds\Moncash\PaymentResponse::class);
