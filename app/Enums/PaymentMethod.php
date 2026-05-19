<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case STRIPE = 'stripe';
    case CASH_ON_DELIVERY = 'cash_on_delivery';
}
