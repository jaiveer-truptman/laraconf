<?php

namespace App\Enums;

enum TalkLength: int
{
    case LIGHTNING = 15;
    case NORMAL = 30;
    case KEYNOTE = 60;
}
