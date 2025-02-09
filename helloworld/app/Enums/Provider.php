<?php

namespace App\Enums;

enum Provider: string
{
    case Github = 'github';
    //case Facebook = 'facebook';
    case Naver = 'naver';
    case Kakao = 'kakao';
}
