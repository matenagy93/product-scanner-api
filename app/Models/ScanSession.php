<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScanSession extends Model
{
    use HasFactory;
	use SoftDeletes;
	
	protected $table = 'scan_sessions';
	
	public function getTotalNetAttribute()
    {
       return $this->sum_products_net - $this->sum_discounts_net;
    }
	
	public function getTotalGrossAttribute()
    {
       return $this->total_net * (1 + $this->sales_tax);
    }
	
	public function products()
    {
        return $this->hasMany(ScanScannedProduct::class, 'scan_session_id');
    }
	
	public function discounts()
    {
        return $this->hasMany(ScanAppliedDiscount::class, 'scan_session_id');
    }
}
