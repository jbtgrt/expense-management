<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExpenseCategoryResource;
use App\Http\Resources\ExpenseCategoryTypeResource;
use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use Nette\Utils\DateTime;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ExpenseCategoryResource::collection(ExpenseCategory::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'display_name' => 'required|string|unique:expense_categories,display_name',
            'description' => 'required|string'
        ]);

        $expenseCategory = ExpenseCategory::create([
            'display_name' => $data['display_name'],
            'description' => $data['description']
        ]);

        return response([
            'data' => ExpenseCategoryResource::collection(ExpenseCategory::all())
        ]);
    }

    public function expCategoryTypes()
    {
        return ExpenseCategoryTypeResource::collection(ExpenseCategory::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseCategory $expenseCategory, Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validatedData = $request->validate([
            'display_name' => 'required|string|unique:expense_categories,display_name,'.$id,
            'description' => 'required|string'
        ]);

        $resource = ExpenseCategory::findOrFail($id);

        $resource->update($validatedData);
     
        return response([
            'data' => ExpenseCategoryResource::collection(ExpenseCategory::all())
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete(); 

        return ExpenseCategoryResource::collection(ExpenseCategory::all());
    }
}
