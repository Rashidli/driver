<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'mark' => $this->mark,
            'model'=> $this->model,
            'production_year' => $this->production_year,
            'plate_no' => $this->plate_no,
            'color' => $this->color,
            'mileage' => $this->mileage,
        ];
    }
}
