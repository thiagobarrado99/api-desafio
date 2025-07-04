<?php

namespace App\Enums;

enum BillHistoricTypeEnum: string
{
    case SMS = 'sms';
    case Whatsapp = 'whatsapp';
    case Mailing = 'mailing';
}
