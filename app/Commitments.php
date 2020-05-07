<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property float $total
 * @property float $balance
 * @property float $monthly
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class Commitments extends Model
{
    use SoftDeletes;
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'title', 'total', 'balance', 'monthly', 'status', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getBalanceStatus(){
        if($this->unlimit == 0){
            return number_format(($this->total - $this->balance) / $this->total * 100, 2);
        } else {
            return $this->total;
        }
        
    }

    public function scopeSumMonthly(Builder $query){
        return $query->where('status', 1)->sum('monthly');
    }


}
