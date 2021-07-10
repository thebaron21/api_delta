<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'status' => 200,
            'data' => [
                "id" => $request->id,
                "name" => $request->name,
                "image" => $request->image,
                "products" => $this->collection($request->products)
            ]
        ];
    }
    public function custome($request)
    {
        return [
            'status' => 200,
            'data' => $request
        ];
    }
}
/*
        "id": 3,
        "name": "ahmedfdf",
        "image": null,
        */