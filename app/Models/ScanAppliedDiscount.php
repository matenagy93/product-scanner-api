<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScanAppliedDiscount extends Model
{
    use HasFactory;
	use SoftDeletes;
	
	protected $table = 'scan_applied_discounts';
	
	public function getSumNetAttribute()
    {
       return $this->unit_value_net * $this->quantity;
    }
}
