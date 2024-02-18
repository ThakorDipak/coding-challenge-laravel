<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserListCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->resource instanceof \Illuminate\Pagination\LengthAwarePaginator) {

            $pagination = [
                'pagination' => [
                    'current_page' => $this->currentPage(),
                    'from'         => $this->firstItem(),
                    'path'         => $this->path(),
                    'total'        => $this->total(),
                    'count'        => $this->count(),
                    'per_page'     => $this->perPage(),
                    'to'           => $this->lastItem(),
                    'next_page'    => $this->currentPage() + 1,
                    'last_page'    => $this->lastPage(),
                    'hasPages'     => $this->hasPages(),
                    'hasMorePages' => $this->hasMorePages(),
                ]
            ];
            return [
                'data' => $this->collection,
                ...$pagination,
            ];
        } else {
            return parent::toArray($request);
        }
    }
}
