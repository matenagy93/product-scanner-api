<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScanScannedProduct extends Model
{
    use HasFactory;
	use SoftDeletes;
	
	protected $table = 'scan_scanned_products';
	
	public function getSumNetAttribute()
    {
       return $this->unit_price_net * $this->quantity;
    }
}
