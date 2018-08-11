<?php

namespace App\Http\Controllers\Api;

use App\Models\Basket;
use Illuminate\Http\Request;

class BasketsController extends ApiController
{
    /**
     * @param int $basketId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($basketId = 0)
    {
        $baskets = Basket::with(['user', 'items']);
        $baskets = $basketId ? $baskets->findOrFail($basketId) : $baskets->get();

        return $this->setResponse($baskets, ['items' => true]);
    }

    /**
     * Добавление Новой карзины вместе с содержимым
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $data = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
        ]);

        $data['hash'] = (string)rand(1, 999999999);
        $basket = new Basket($data);
        $basket->user()->associate($user);
        $basket->saveOrFail();

        $items = [];

        foreach ($request->post('items', []) as $item) {
            $validator = \Validator::make($item, [
                'productId' => ['required', 'numeric', 'max:255'],
                'weight' => ['required', 'numeric'],
            ]);
            !$validator->fails() || abort(500);

            $items[array_get($item, 'productId')] = [
                'weight' => array_get($item, 'weight')
            ];
        }
        $basket->products()->sync($items) || abort(500);

        return $this->setResponse($basket, ['full' => true], 201);
    }

    /**
     * Обновление названия и содержимого карзины
     *
     * @param Request $request
     * @param $basketId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $basketId)
    {
        /** @var Basket $basket */
        $basket = Basket::findOrFail($basketId);

        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
        ]);

        $basket->name = $request->post('name', $basket->name);

        $basket->save() || abort(500);

        $items = [];

        foreach ($request->post('items', []) as $item) {
            $validator = \Validator::make($item, [
                'productId' => ['required', 'numeric', 'max:255'],
                'weight' => ['required', 'numeric'],
            ]);
            !$validator->fails() || abort(500);

            $items[array_get($item, 'productId')] = [
                'weight' => array_get($item, 'weight')
            ];
        }
        $basket->products()->sync($items) || abort(500);

        return $this->setResponse($basket, ['full' => true]);
    }

    public function destroy($basketId)
    {
        $product = Basket::findOrFail($basketId);

        return $product->delete()
            ? $this->setResponse($product->id)
            : abort(500);
    }
}
