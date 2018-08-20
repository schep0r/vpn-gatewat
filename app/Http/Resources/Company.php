<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Company extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'quota' => $this->quota,
            'user_quota_view' => $this->convertSpace($this->quota),
            $this->mergeWhen($this->traffic !== null, [
                'traffic' => $this->traffic,
                'user_traffic_view' => $this->convertSpace($this->traffic),
            ]),
        ];
    }

    private function convertSpace ($value)
    {
        if ($value === null) {
            return;
        }

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
