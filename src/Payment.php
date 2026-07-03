<?php

declare(strict_types=1);
use Mds\Moncash\PaymentResponse;

// Compatibility bridge: loads PaymentResponse, which defines the Mds\Moncash\Payment alias.
// @deprecated Use Mds\Moncash\PaymentResponse instead.
class_exists(PaymentResponse::class);
