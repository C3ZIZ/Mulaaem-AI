<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Recruiter = 'recruiter';
    case Candidate = 'candidate';
}