<?php

namespace App\Enum;

enum AccountStatusEnum: string
{
    case ACTIVE = 'active';
    case PENDING = 'pending';
    case BLOCKED = 'blocked';
    case DELETED = 'deleted';
    case BANNED = 'banned';
}
