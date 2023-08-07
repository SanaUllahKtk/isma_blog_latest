<?php

namespace App\Enums;

enum AuthenticationTypeEnum: string
{
    case NEW = 'new';
    case OLD = 'old';
    case NOT_FOUND = 'not_found';
}
