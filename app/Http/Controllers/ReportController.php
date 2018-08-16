<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index($month)
    {
        $companies = Company::quotaOverDraft($month)->get();

        return response()->json($companies);
    }
}
