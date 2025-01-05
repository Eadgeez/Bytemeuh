<?php

namespace App;

enum OrderStatusEnum: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case SHIPPED = 'shipped';
    case DELIVERED = 'delivered';
    case CANCELED = 'canceled';
    case REFUNDED = 'refunded';
    case RETURNED = 'returned';
    case LOST = 'lost';
    case DAMAGED = 'damaged';
    case STOLEN = 'stolen';
    case UNKNOWN = 'unknown';
}
