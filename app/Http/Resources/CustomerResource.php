<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){
        return [
			'id' => $this->id,
			'firstname' => $this->firstname ?? '',
			'lastname'  => $this->lastname ?? '',
			'email'     => $this->email,
            'picture'   => $this->profile_picture ?? 'dummy.jpg',
            'city'      => $this->city,
            'storename' => $this->business_name ?? $this->firstname.' '.$this->lastname,
            'type'      => $this->types->name ?? '-',
            'staff_type'=> $this->name ?? '-',
            'address'   => $this->address,
            'unpaid_invoice' => count($this->invoice) ?? 0,
            'total_due' => showPrice(round($this->invoice->sum('grand_total'),2) ?? 0),
			'status' => $this->status,
			
			'created_at' => $this->created_at,
		];
    }
}
