<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){
        return [
			'id'            => $this->id,
            'invoice_no'    => $this->invoice_number ?? '-',
            'orderid'       => $this->order->po_number,
			'shopname'      => $this->user->business_name ??$this->firstname.' '.$this->lastname,
            'due_date'    => $this->due_date,
            'due_amount'  => showPrice($this->grand_total-$this->paid_total),
            'subtotal'      => showPrice($this->sub_total),
            'tax'           => showPrice($this->tax),
            'grand_total'   => showPrice($this->grand_total ?? 0),
			'status'        => $this->status,
			'created_at'    => $this->created_at,
			'grandtotal'    => $this->grand_total,
			'paidtotal'     => $this->paid_total
			
			
		];
    }
}
