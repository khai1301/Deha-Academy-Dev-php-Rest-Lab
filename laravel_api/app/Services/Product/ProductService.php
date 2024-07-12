<?php

namespace App\Services\Product;
use App\Models\Product;

class ProductService
{
    /**
     * Create a new class instance.
     */
    protected $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    public function index() {
        return $this->product->paginate(10);
    }
    public function show($id) {
        return $this->product->findOrFail($id);
    }
    public function create($data){
        return $this->product->create($data);
    }
    public function update($data, $id) {
        $product = $this->product->findOrFail($id);
        $product->update($data);
        return $product;
    }
    public function destroy($id) {
        $product = $this->product->findOrFail($id);
        $product->delete();
        return true;
    }
    public function search($name){
        return $this->product->where('name' , 'like' , '%'.$name.'%')->paginate(10);
    }
}
