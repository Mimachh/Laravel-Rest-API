<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSiteResouce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "url" => $this->url,
            "token" => $this->token,
            "monthly_mail" => $this->monthly_mail,
            "total_mail" => $this->total_mail,
            "created_at" => $this->created_at
        ];
    }
}
