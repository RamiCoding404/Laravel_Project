<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use App\Http\Resources\CompanyCollection;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // $companies = Company::all();
            // $companies = CompanyResource::collection(Company::all()); //baigeb aly a5trnah fe company resource
            $companies = new CompanyCollection(Company::all());
            // return $companies;
            return response()->json($companies);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate lely da5l
        $request->validate([
            'name' => 'required|string|max:200',
            'owner' => 'required',
            'tax_number' => 'required|string|max:20'
        ]);
        try {
            $c =  Company::create($request->all()); //create fel database
            return response()->json([ //response lel json api
                'status' => 'Company Created', //massage  .
                'company' => new CompanyResource($c) // hna baigeb aly a5trnah fe companyresource .
            ]);
        } catch (Exception $e) { //hma law 7asl failed
            return response()->json([
                'status' => 'faild',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // $company = Company::findOrFail($id);
            $company = new CompanyResource(Company::findOrFail($id)); //hna baishof id we yageb al7agat aly a5trnah fe company resource
            return response()->json([
                'status' => 'Company returned',
                'company' => $company
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'faild',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) //hna baistny id mo3in
    {
        try {
            $company = Company::findOrFail($id); // baidwr we ya5od id aly a5trnah
            $company->update($request->all()); //bai3ml update lel id aly a5trnah lel data bta3tro
            return response()->json([
                'status' => 'Company updated',
                'company' => new CompanyResource($company)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'faild',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) //baia5od id
    {
        try {
            $compony = Company::findOrFail($id);
            if ($compony) {
                $compony->delete();
                return response()->json([
                    'status' => 'Company Deleted',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'faild',
                'message' => $e->getMessage()
            ]);
        }
    }
}
