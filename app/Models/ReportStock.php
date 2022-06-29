<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportStock extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'book_id','month','year','first_stock','incurred','final_stock'
    ];
    protected $primaryKey = 'stock_id';
    protected $table = 'tbl_report_stock';
}
