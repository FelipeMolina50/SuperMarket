<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = auth()->user()->products()->orderBy('id', 'desc')->get();
        return view('inventory.index', compact('products'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'cat' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product = auth()->user()->products()->create($validatedData);
        
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
        $this->authorize('update', $product);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,'.$product->id,
            'cat' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image_path);
            }
            $validatedData['image_path'] = $request->file('image')->store('products', 'public');
        }

        $oldStock = $product->stock;
        
        $product->update($validatedData);

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
        $this->authorize('delete', $product);

        $product->delete();
        return back()->with('success', 'Producto eliminado');
    }
}
