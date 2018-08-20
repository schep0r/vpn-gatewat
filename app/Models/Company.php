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

    public function scopeQuotaOverDraft($query, $month)
    {
        return $query
            ->selectRaw('companies.id, companies.name, companies.quota, SUM(transfers.transferred) as traffic')
            ->join('users', 'users.company_id', '=', 'companies.id')
            ->join('transfers', 'transfers.user_id', '=', 'users.id')
            ->whereMonth('transfers.date', $month)
            ->groupBy('companies.id')
            ->havingRaw('SUM(transfers.transferred) > companies.quota')
            ->orderBy('traffic', 'DESC')
        ;
    }
}
