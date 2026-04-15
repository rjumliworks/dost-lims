<?php

namespace App\Models;

use Hashids\Hashids;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
class InventoryItem extends Model
{
    protected $fillable = [
        'code',
        'old_code',
        'name',
        'img',
        'reorder',
        'unit_id',
        'category_id',
        'agency_id',
        'laboratory_id',
        'user_id',
        'is_equipment'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $user = Auth::user();

                if (empty($model->agency_id)) {
                    $model->agency_id = $user->profile?->agency_id;
                }
            }
        });
    }

    protected $appends = ['reference'];

    public function getReferenceAttribute(): string
    {
        return (new Hashids('krad', 10))->encode($this->id);
    }

    public function stocks()
    {
        return $this->hasMany('App\Models\InventoryStock', 'item_id');
    }

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');
    }

    public function laboratory()
    {
        return $this->belongsTo('App\Models\ListLaboratory', 'laboratory_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'category_id', 'id');
    }

    public function unittype()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'unit_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function isBelowReorderLevel()
    {
        $totalStock = $this->stocks()->sum('onhand');
        return $totalStock <= $this->reorder && $totalStock != 0;
    }

    public function getUpdatedAtAttribute($value){ return date('M d, Y g:i a', strtotime($value));}
    public function getCreatedAtAttribute($value){ return date('F d, Y g:i a', strtotime($value));}
}
