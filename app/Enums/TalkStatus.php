<?php

namespace App\Enums;

enum TalkStatus: int
{
    case REJECTED = 0;
    case APPROVED = 1;
    case SUBMITTED = 2;
}
