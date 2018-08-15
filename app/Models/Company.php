<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'quota',
    ];

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    /**
     * Get the company's quota amount.
     *
     * @param  string  $value
     * @return string
     */
    public function getQuotaAttribute($value)
    {
        $quota = $value;

        if ($quota > 1000000000000) {
            return number_format($quota/1000000000000, 2) . " TB";
        }

        if ($quota > 1000000000) {
            return number_format($quota/1000000000, 2) . " GB";
        }

        if ($quota > 1000000) {
            return number_format($quota/1000000, 2) . " MB";
        }

        if ($quota > 1000) {
            return number_format($quota/1000, 2) . " KB";
        }

        return $quota . " B";
    }
}
