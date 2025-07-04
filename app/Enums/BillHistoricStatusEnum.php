<?php

namespace App\Enums;

enum BillHistoricStatusEnum: string
{
    case Done = 'done';
    case Failure = 'failure';
}
