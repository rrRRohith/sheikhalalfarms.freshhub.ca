<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){
        return [
			'id'              => $this->id,
			'invoice_number'  => $this->invoice->invoice_number,
			'shopname'        => $this->user->business_name ?? $this->user->firstname.' '.$this->user->lastname,
            'name'            => $this->user->firstname.' '.$this->user->lastname,
            'address'         => $this->delivery->address.', '.$this->delivery->city.', '.$this->delivery->province.', '.$this->delivery->postalcode,
            'shipping_date'   => $this->shipping_date,
            'quantity'        => $this->item->sum('quantity') ?? 0,
            'grand_total'     => showPrice($this->grand_total ?? 0),
			'assign_driver'   => $this->assign_driver,
			'driver'          => $this->assign_driver==1 ? ($this->driver->firstname.' '.$this->driver->lastname) : '' ,
			'driver_id'       => $this->driver_id,
		];
    }
}
