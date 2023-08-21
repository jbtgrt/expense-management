<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $expenses = $this->allExpenses($request->user_id);

        $expensesByCategory = collect($expenses)
            ->groupBy('expense_category')
            ->map(function ($expenses) {
                return $expenses->sum('amount');
            });

        $keysArray = $expensesByCategory->keys()->all();
        $valuesArray = $expensesByCategory->values()->all();

        $transformedData = $expensesByCategory->map(function ($amount, $category) {
            return [
                'category' => $category,
                'amount' => $amount,
            ];
        })->values()->all();

        return response()->json(['categories' => $keysArray, 'amounts' => $valuesArray, 'expenses'=> $transformedData]);
    }

    private function allExpenses($id){
        $expenses = Expense::query()
            ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->where('user_id', $id)
            ->get(['expenses.*', 'expense_categories.display_name as expense_category']);

        return $expenses;
    }
}
