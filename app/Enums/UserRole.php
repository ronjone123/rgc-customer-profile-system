<?php
namespace App\Enums;

enum UserRole: string
{
    case SUPERADMIN = 'superadmin';
    case HEAD_ADMIN = 'head_admin';
    case BRANCH_ADMIN = 'branch_admin';
    case USER = 'user';
}

