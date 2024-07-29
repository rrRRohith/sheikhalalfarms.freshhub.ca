<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){
        return [
			'id' => $this->id,
			'name' => $this->name ?? '',
			'sku'  => $this->sku ?? '',
            'description' => $this->description ?? '-',
            'category'      => $this->category->name ?? '-',
            'weight'   => getWeight($this->weight).defWeight(),
            'price' => showPrice(getRate($this->price ?? 0)),
            'picture' => $this->picture ?? '',
			'status' => $this->status,
			'qty'    =>$this->qty,
			
			'created_at' => $this->created_at,
		];
    }
}
