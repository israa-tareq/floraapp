<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FlowerController extends Controller
{
    // Display all flowers.
    public function index()
    {
        $flowers = Flower::latest()->paginate(10);

        return view('admin.flowers.index', compact('flowers'));
    }


    // Display the form for creating a flower.
    public function create()
    {
        return view('admin.flowers.create');
    }


    // Save a new flower.
    public function store(Request $request)
    {
        // Validate the submitted form.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:100',
            'price_per_stem' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_available' => 'nullable|boolean',
        ]);

        // Store the uploaded image if one was provided.
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')
                ->store('flowers', 'public');
        }

        // Convert the availability checkbox into a boolean.
        $validated['is_available'] = $request->boolean('is_available');

        // Create the flower in the database.
        Flower::create([
            'name' => $validated['name'],
            'color' => $validated['color'],
            'price_per_stem' => $validated['price_per_stem'],
            'stock_quantity' => $validated['stock_quantity'],
            'image_path' => $validated['image_path'] ?? null,
            'is_available' => $validated['is_available'],
        ]);

        return redirect()
            ->route('admin.flowers.index')
            ->with('success', 'Flower added successfully!');
    }


    // Display the form for editing a flower.
    public function edit(Flower $flower)
    {
        return view('admin.flowers.edit', compact('flower'));
    }


    // Update an existing flower.
    public function update(Request $request, Flower $flower)
    {
        // Validate the submitted form.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:100',
            'price_per_stem' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_available' => 'nullable|boolean',
        ]);

        // Keep the current image unless a new image is uploaded.
        $imagePath = $flower->image_path;

        if ($request->hasFile('image')) {

            // Store the new image.
            $imagePath = $request->file('image')
                ->store('flowers', 'public');

            // Delete the old image after successfully storing the new one.
            if ($flower->image_path) {
                Storage::disk('public')->delete($flower->image_path);
            }
        }

        // Update the flower information.
        $flower->update([
            'name' => $validated['name'],
            'color' => $validated['color'],
            'price_per_stem' => $validated['price_per_stem'],
            'stock_quantity' => $validated['stock_quantity'],
            'image_path' => $imagePath,
            'is_available' => $request->boolean('is_available'),
        ]);

        return redirect()
            ->route('admin.flowers.index')
            ->with('success', 'Flower updated successfully!');
    }


    // Delete a flower.
    public function destroy(Flower $flower)
    {
        // Delete the associated image from storage.
        if ($flower->image_path) {
            Storage::disk('public')->delete($flower->image_path);
        }

        // Delete the flower record from the database.
        $flower->delete();

        return redirect()
            ->route('admin.flowers.index')
            ->with('success', 'Flower deleted successfully!');
    }
}