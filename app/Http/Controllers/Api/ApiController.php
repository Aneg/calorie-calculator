<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


class ApiController extends Controller
{
    protected function setResponse($data = [], array $options = [], $code = 200)
    {
        $data = $this->generateModelCollection($data, $options) ?: [];

        $response = [
            'code'    => (int)$code,
            'message' => trans("code.{$code}"),
            'data'    => $data
        ];

        return response()->json($response);
    }

    private function generateModelCollection($items, array $options = [])
    {
        $data = [];

        if ($items instanceof Collection) {
            foreach ($items as $item) {
                if (method_exists($item, 'toApi'))
                    $data[] = $item->toApi($options);
            }
        } elseif ($items instanceof Model && method_exists($items, 'toApi')) {
            $data = $items->toApi($options);
        } else {
            $data = $items;
        }

        return $data;
    }
}