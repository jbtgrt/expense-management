<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Utils\DateTime;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'expense_category_id' => $this->expense_category_id,
            'expense_category' => $this->expense_category_display_name,
            'entry_date' => (new DateTime($this->entry_date))->format('Y-m-d'),
            'created_at' => (new DateTime($this->created_at))->format('Y-m-d')
        ];
    }
}
