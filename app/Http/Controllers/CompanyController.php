<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompany;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\Company as CompanyResource;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        return new CompanyCollection(Company::all());
    }

    public function store(StoreCompany $request)
    {
        $validatedData = $request->validated();

        $company = Company::create($validatedData);
        $company = Company::find($company->id);

        return (new CompanyResource($company))
            ->response()
            ->setStatusCode(201);
    }

    public function update(StoreCompany $request, $id)
    {
        $validatedData = $request->validated();

        $company = Company::find($id);
        $company->fill($validatedData);
        $company->save();

        return new CompanyResource($company);
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
