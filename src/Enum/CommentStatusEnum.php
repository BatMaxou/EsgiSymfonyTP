<?php

namespace App\Enum;

enum CommentStatusEnum: string
{
    case PUBLISHED = 'published';
    case PENDING = 'pending';
    case REJECTED = 'rejected';
}
