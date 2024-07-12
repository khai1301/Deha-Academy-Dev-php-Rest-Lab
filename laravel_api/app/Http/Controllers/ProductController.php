<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index()
    {
        $products = $this->productService->index();
        $productResource = new ProductCollection($products);

        return $this->sentSuccessfulResponse(Response::HTTP_OK, 'Get successful', $productResource);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->all();
        $newProduct = $this->productService->create($validated);
        $productResource = new ProductResource($newProduct);
        return $this->sentSuccessfulResponse(Response::HTTP_OK, 'Create successful', $productResource);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->productService->show($id);
        $productResource = new ProductResource($product);
        return $this->sentSuccessfulResponse(Response::HTTP_OK, 'Find successful', $productResource);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = $this->productService->update($request->all(), $id);
        $productResource = new ProductResource($product);
        return $this->sentSuccessfulResponse(Response::HTTP_OK, 'Update successful', $productResource);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->productService->destroy($id);
        return $this->sentSuccessfulResponse(Response::HTTP_OK, 'Delete successful');
    }

    public function search(string $name)
    {
        $product = $this->productService->search($name);
        $productResource = new ProductCollection($product);
        return $this->sentSuccessfulResponse(Response::HTTP_OK, 'Find by name successful', $productResource);
    }
}
