<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompany;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();

        return response()->json($companies);
    }

    public function store(StoreCompany $request)
    {
        $validatedData = $request->validated();

        $company = Company::create($validatedData);

        return response()->json($company, 201);
    }

    public function update(StoreCompany $request, $id)
    {
        $validatedData = $request->validated();

        $company = Company::find($id);
        $company->fill($validatedData);
        $company->save();

        return response()->json($company);
    }

    public function destroy($id)
    {
        $company = Company::find($id);
        $company->delete();

        return response()->json([
            'success' => true,
            'message' => 'Company was deleted'
        ]);
    }
}
