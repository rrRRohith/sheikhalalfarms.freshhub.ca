<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){
        return [
			'id'            => $this->id,
            'invoice_no'    => $this->invoice->invoice_number ?? $this->po_number,
			'shopname'      => $this->business_name ?? $this->firstname.' '.$this->lastname,
            'name'          => $this->firstname.' '.$this->lastname,
            'order_date'    => $this->order_date,
            'shipping_date' => $this->shipping_date,
            'quantity'      => $this->item->sum('quantity') ?? 0,
            'weight'        => getWeight($this->item->sum('weight') ?? 0).defWeight(),
            'grand_total'   => showPrice($this->grand_total ?? 0),
			'status'        => $this->status,
			'created_at'    => $this->created_at,
			'storename'     => $this->user->business_name ?? $this->user->firstname.' '.$this->user->lastname,
			'po_number'     => $this->po_number,
			'paidtotal'     => $this->invoice->paid_total ?? 0,
		];
    }
}
