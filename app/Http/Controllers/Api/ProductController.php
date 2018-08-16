<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    public function show($productId = 0)
    {
        $products = Product::with('user');
        $products = $productId ? $products->findOrFail($productId) : $products->get();

        return $this->setResponse($products, [],true);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $data = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'protein' => 'required|numeric|max:100',
            'fat' => 'required|numeric|max:100',
            'carbohydrate' => 'required|numeric|max:100',
            'calories' => 'required|numeric|max:1000',
        ]);

        $data['hash'] = (string)rand(1, 999999999);
        $products = Product::create($data);
        $products->user()->associate($user);

        return $this->setResponse($products, ['full' => true], 201);
    }

    public function update(Request $request, $productId)
    {
        /** @var Product $role */
        $product = $this->permissionsModel = Product::findOrFail($productId);

        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'protein' => 'required|numeric|max:100',
            'fat' => 'required|numeric|max:100',
            'carbohydrate' => 'required|numeric|max:100',
            'calories' => 'required|numeric|max:1000',
        ]);

        $product->name         = $request->post('name', $product->name);
        $product->protein      = $request->post('protein', $product->product);
        $product->fat          = $request->post('fat', $product->fat);
        $product->carbohydrate = $request->post('carbohydrate', $product->carbohydrate);
        $product->calories     = $request->post('calories', $product->calories);

        return $product->save()
            ? $this->setResponse($product, ['full' => true])
            : abort(500);
    }

    public function destroy($productId)
    {
        $product = $this->permissionsModel = Product::findOrFail($productId);

        return $product->delete()
            ? $this->setResponse($this->permissionsModel->id)
            : abort(500);
    }
}
