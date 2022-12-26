<?php

namespace OutMart\Resources\Catalog;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleResource extends JsonResource
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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'pricing' => [
                'price' => $this->price,
                'discount_value' => $this->discount_value,
                // 'discount_configurable_value' => $this->configurable->final_price - $this->final_price,
                'final_price' => $this->final_price,
            ],
        ];
    }
}
