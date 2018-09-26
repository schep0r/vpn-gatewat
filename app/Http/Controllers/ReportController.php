<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Resources\CompanyCollection;

class ReportController extends Controller
{
    public function index($month)
    {
        $companies = Company::quotaOverDraft($month)->get();

        return new CompanyCollection($companies);
    }
}
