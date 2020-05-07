<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
/**
 * @property integer $id
 * @property string $kod
 * @property string $title
 * @property int $master
 * @property string $created_at
 * @property string $updated_at
 */
class Lookups extends Model
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
    protected $fillable = ['kod', 'title', 'master', 'created_at', 'updated_at'];

    public function getMaster(){
        return ($this->master == null) 
            ? $this->id 
            : $this->master;
    }

    public function scopeByIncomeList(Builder $query){
        return $query->where('master', 2);
    }

    public function scopeByExpensesList(Builder $query){
        return $query->where('master', 3);
    }

}
