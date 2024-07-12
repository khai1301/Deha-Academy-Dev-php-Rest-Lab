<?php

namespace App\Http\Resources\Product;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'products' => $this->collection,
            'meta' => [
                'total' => $this->total(), 
                'links' => [
                    'first' => $this->url(1),
                    'last' => $this->url($this->lastPage()),
                    'prev' => $this->previousPageUrl(),
                    'next' => $this->nextPageUrl(),
                    'current_page' => $this->currentPage(),
                    'last_page' => $this->lastPage()
                ],
                'totalPage' => $this->lastPage(),
            ]
        ];
    }
}
