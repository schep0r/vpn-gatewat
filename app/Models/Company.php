<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $appends = array('user_quota_view', 'user_traffic_view');

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

    /**
     * Get the company's quota amount.
     *
     * @return string
     */
    public function getUserQuotaViewAttribute()
    {
        $quota = $this->convertSpace($this->quota);

        return $quota;
    }

    /**
     * Get the company's quota amount.
     *
     * @return string
     */
    public function getUserTrafficViewAttribute()
    {
        if ($this->traffic === null) {
            return;
        }
        $quota = $this->convertSpace($this->traffic);

        return $quota;
    }

    private function convertSpace ($value)
    {
        if ($value >= 1000000000000) {
            return number_format($value/1000000000000, 2) . " TB";
        }

        if ($value >= 1000000000) {
            return number_format($value/1000000000, 2) . " GB";
        }

        if ($value >= 1000000) {
            return number_format($value/1000000, 2) . " MB";
        }

        if ($value >= 1000) {
            return number_format($value/1000, 2) . " KB";
        }

        return $value . " B";
    }
}
