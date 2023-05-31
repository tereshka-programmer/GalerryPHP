<?php

namespace App\Enum;

enum ReviewStatus: string
{
    case WaitingForApproval = "waiting_for_approval";
    case Published = "published";
    case Revoked = "revoked";
}
