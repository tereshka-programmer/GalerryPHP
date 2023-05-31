<?php

namespace App\Enum;

enum PictureStatus: string
{
    case Draft = "draft";
    case Published = "published";
    case Revoked = "revoked";

}
