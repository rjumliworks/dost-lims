<?php

namespace App\Models;

use Hashids\Hashids;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class QuotationSample extends Model
{
    protected $fillable = [
        'code',
        'name',
        'customer_description',
        'description',
        'samplename_id',
        'sampletype_id',
        'category_id',
        'quotation_id'
    ];

    public function getReferenceAttribute(): string
    {
        return (new Hashids('krad', 10))->encode($this->id);
    }

    public function quotation()
    {
        return $this->belongsTo('App\Models\Quotation', 'quotation_id', 'id');
    }

    public function sampletype()
    {
        return $this->belongsTo('App\Models\SampleType', 'sampletype_id', 'id');
    }

    public function samplename()
    {
        return $this->belongsTo('App\Models\SampleName', 'samplename_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\SampleCategory', 'category_id', 'id');
    }

    public function analyses()
    {
        return $this->hasMany('App\Models\QuotationAnalysis', 'sample_id');
    }
    
    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
    }

    public function getCodeAttribute($value)
    {
        return Str::after($value, '-');
    }
}
