<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'label', 'invoice_id'
    ];

    public function getInvoice() {
        return $this->label . '-' . date_format($this->created_at, 'Y') . '-' . sprintf("%06d", $this->invoice_id);
    }
}
