<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $kategori_id
 * @property string $log_reason
 * @property float $log_rm
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Lookup $lookup
 * @property User $user
 */
class TransactionLogs extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'kategori_id', 'log_reason', 'log_rm', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lookup()
    {
        return $this->belongsTo('App\Lookups', 'kategori_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeLatestTransaction(Builder $query, $limit){
        return $query->where('user_id', \Auth::user()->id)->latest()->limit($limit);
    }

    public function scopeMonthIncome(Builder $query){
        return $query->whereMonth('created_at', Carbon::now()->month);
    }
}
