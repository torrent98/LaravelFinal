<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MechanicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     * @return array<string, mixed>
     */

    public static $wrap = 'mechanic';

    public function toArray(Request $request): array
    {
        return [
            'name' => $this->resource->name,
            'phone_number' => $this->resource->phone_number,
            'years_of_experience' => $this->resource->years_of_experience,
            'email' => $this->resource->email,
        ];
    }
}
