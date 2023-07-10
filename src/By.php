<?php

namespace Mds\Moncash;

/**
 * PaymentDetailBy
 * @final
 */
enum By: string
{
    case TRANSACTION = "transaction";
    case ORDER = "order";
}
