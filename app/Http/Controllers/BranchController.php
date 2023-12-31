<?php

namespace App\Http\Controllers;

use App\Models\Branch;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $branches = Branch::query();
        if ($request->has('search')) {
            $branches->where('name', 'like', '%' . $request->search . '%')->orWhere('location', 'like', '%' . $request->search . '%');
        }

        return view('branches.index', ['branches' => $branches->orderBy('created_at', 'desc')->orderBy('name')->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('branches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'company_id' => 'required',
        ]);
        Branch::create($request->except('_token'));
        return redirect()->route('branches.index')->with('added', 'New Branch Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $branch = Branch::findOrFail($id);
        return view('branches.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'company_id' => 'required'

        ]);
        $branch = Branch::findOrFail($id);
        $branch->update($request->except('_token'));
        return redirect()->route('branches.index')->with('added', ' Updated Branch');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Branch::destroy($id);
            return redirect()->route('branches.index')->with('added', 'branche Deleted');
        } catch (Exception  $e) {
            Log::info($e->getMessage());
            return redirect()->route('branches.index');
        }
    }
}
