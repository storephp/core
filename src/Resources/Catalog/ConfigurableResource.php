<?php

namespace OutMart\Resources\Catalog;

use Illuminate\Http\Resources\Json\JsonResource;

class ConfigurableResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return $this->resource->toArray();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'pricing' => [
                'price' => $this->price,
                'discount_value' => $this->discount_value,
                'final_price' => $this->final_price,
            ],
            'simples' => SimpleResource::collection($this->simples),
        ];
    }
}
