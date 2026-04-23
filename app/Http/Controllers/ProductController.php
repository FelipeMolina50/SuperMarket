<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('inventory.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'cat' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $product = Product::create($request->all());
        
        if ($request->stock > 0) {
            $product->movements()->create([
                'type' => 'entry',
                'quantity' => $request->stock,
                'description' => 'Stock inicial manual'
            ]);
            $product->updateStockFromMovements();
        }

        return back()->with('success', 'Producto agregado con éxito');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,'.$product->id,
            'cat' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $oldStock = $product->stock;
        
        $product->update($request->all());

        $newStock = $request->stock;
        if ($newStock > $oldStock) {
            $product->movements()->create([
                'type' => 'entry',
                'quantity' => $newStock - $oldStock,
                'description' => 'Ajuste manual (Entrada)'
            ]);
            $product->updateStockFromMovements();
        } elseif ($newStock < $oldStock) {
            $product->movements()->create([
                'type' => 'exit',
                'quantity' => $oldStock - $newStock,
                'description' => 'Ajuste manual (Salida)'
            ]);
            $product->updateStockFromMovements();
        }

        return back()->with('success', 'Producto actualizado con éxito');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Producto eliminado');
    }
}
