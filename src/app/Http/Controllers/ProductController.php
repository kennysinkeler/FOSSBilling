<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    function index(): Factory|View|Application
    {
        $products = Product::all();
        return view("client.product.index", ['product' => $products]);
    }

    /**
     * @param Product $product
     * @return Factory|View|Application
     */
    function show(Product $product): Factory|View|Application
    {
        return view("client.product.show", ["product" => $product]);
    }
}
