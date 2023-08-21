<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Resources\ExpenseResource;
use Illuminate\Http\Request;
use App\Models\Expense;
use Nette\Utils\DateTime;
use Illuminate\Support\Facades\Auth;


class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $expenses = $this->allExpenses($request->user_id);
        return response([
            'data' => ExpenseResource::collection($expenses)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {   
        $data = $request->validated();

        $data['entry_date'] = (new DateTime($data['entry_date']))->format('Y-m-d H:i:s');

        $expense = Expense::create($data);

        $expenses = $this->allExpenses($request->user_id);

        return response([
            'data' => ExpenseResource::collection($expenses)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense, Request $request)
    {
        // return new UserResource($request->$id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validatedData = $request->validate([
            'expense_category_id' => 'required|int',
            'amount' => 'required|int',
            'entry_date' => 'date'
        ]);

        $resource = Expense::findOrFail($id);

        $resource->update($validatedData);

        $expenses = $this->allExpenses($request->user_id);

        return response([
            'data' => ExpenseResource::collection($expenses)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     //
    // }
    public function destroy(Expense $expense, Request $request)
    {
        $expense->delete(); 

        $expenses = $this->allExpenses($request->user_id);

        return response([
            'data' => ExpenseResource::collection($expenses)
        ]);
    }


    private function allExpenses($id){
        $expenses = Expense::query()
            ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->where('user_id', $id)
            ->orderBy('expenses.created_at', 'ASC')
            ->get(['expenses.*', 'expense_categories.display_name as expense_category_display_name']);

        return $expenses;
    }
}
