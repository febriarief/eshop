<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'customer_name',
        'customer_address',
        'customer_email',
        'status',
        'total'
    ];

    public static function generateId()
    {
        $currentDate = Carbon::now();
        $currentYearMonth = $currentDate->format('Ym');

        $lastRequest = self::where('id', 'like', "ORDER{$currentYearMonth}%")
            ->orderBy('id', 'desc')
            ->first();

        $increment = $lastRequest ? intval(substr($lastRequest->id, -4)) + 1 : 1;

        $incrementFormatted = str_pad($increment, 4, '0', STR_PAD_LEFT);
        $purchaseRequestId = "ORDER{$currentYearMonth}{$incrementFormatted}";

        return $purchaseRequestId;
    }

    public function detail()
    {
        return $this->hasMany(\App\Models\OrderDetail::class, 'order_id', 'id');
    }
}
