<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Book extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $parent = parent::toArray($request);
        $data['categories'] = $this->categories;
        $data = array_merge($parent, $data);
        return [
            'status' => 'success',
            'message' => 'book data',
            'data' => $data,
       ];
    }
}
