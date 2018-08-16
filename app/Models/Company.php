<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $appends = array('user_quota_view');
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
            ->select('companies.*')
            ->addSelect('transfers.*')
            ->join('users', 'users.company_id', '=', 'companies.id')
            ->join('transfers', 'transfers.user_id', '=', 'users.id')
            ->selectRaw('SUM((transfers.transferred) as traffic)')
            ->groupBy('SUM((transfers.transferred)')
            ->havingRaw('SUM((transfers.transferred) > ?', [0])

//            ->selectRaw('sum(transfers.transferred) as sum,')

        ;
    }

    /**
     * Get the company's quota amount.
     *
     * @param  string  $value
     * @return string
     */
    public function getUserQuotaViewAttribute()
    {
        $quota = $this->quota;

        if ($quota >= 1000000000000) {
            return number_format($quota/1000000000000, 2) . " TB";
        }

        if ($quota >= 1000000000) {
            return number_format($quota/1000000000, 2) . " GB";
        }

        if ($quota >= 1000000) {
            return number_format($quota/1000000, 2) . " MB";
        }

        if ($quota >= 1000) {
            return number_format($quota/1000, 2) . " KB";
        }

        return $quota . " B";
    }
}
