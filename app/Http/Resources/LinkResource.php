<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'long_url' => $this->long_url,
            'short_url' => route('short', ['short' => $this->short_url]),
            'expiration_date' => $this->expiration_date,
            'created_at' => $this->created_at,

        ];
    }
}
