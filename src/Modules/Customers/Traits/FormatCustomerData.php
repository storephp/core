<?php

namespace Bidaea\OutMart\Modules\Customers\Traits;

trait FormatCustomerData
{
    public function toArray()
    {
        $data = [
            'id' => $this->id,
            'metadata' => $this->metadata,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if ($this->relationLoaded('customerable')) {
            $data['user_id'] = $this->user_id;
            $data['name'] = $this->name;
            $data['email'] = $this->email;
        }

        if ($this->relationLoaded('addresses')) {
            $data['addresses'] = $this->addresses;
        }

        return $data;
    }
}
