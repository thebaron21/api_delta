<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use FilterableResource;

class UserResource extends JsonResource
{
   
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  $request;
        
    }
}
