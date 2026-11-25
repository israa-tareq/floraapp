<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PreMadeBouquet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PreMadeBouquetController extends Controller
{
    // Display all pre-made bouquets.
    public function index()
    {
        $bouquets = PreMadeBouquet::latest()->paginate(10);

        return view('admin.bouquets.index', compact('bouquets'));
    }


    // Display the form for creating a bouquet.
    public function create()
    {
        return view('admin.bouquets.create');
    }


    // Save a new bouquet.
    public function store(Request $request)
    {
        // Validate the submitted form.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);

        // Store the uploaded image.
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')
                ->store('bouquets', 'public');
        }

        // Convert the featured checkbox into a boolean.
        $validated['is_featured'] = $request->boolean('is_featured');

        // Create the bouquet in the database.
        PreMadeBouquet::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock_quantity' => $validated['stock_quantity'],
            'image_path' => $validated['image_path'] ?? null,
            'is_featured' => $validated['is_featured'],
        ]);

        return redirect()
            ->route('admin.bouquets.index')
            ->with('success', 'Bouquet added successfully!');
    }


    // Display the form for editing a bouquet.
    public function edit(PreMadeBouquet $bouquet)
    {
        return view('admin.bouquets.edit', compact('bouquet'));
    }


    // Update an existing bouquet.
    public function update(Request $request, PreMadeBouquet $bouquet)
    {
        // Validate the submitted form.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);

        // Keep the current image unless a new image is uploaded.
        $imagePath = $bouquet->image_path;

        if ($request->hasFile('image')) {

            // Store the new image.
            $imagePath = $request->file('image')
                ->store('bouquets', 'public');

            // Delete the old image.
            if ($bouquet->image_path) {
                Storage::disk('public')->delete($bouquet->image_path);
            }
        }

        // Update the bouquet information.
        $bouquet->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock_quantity' => $validated['stock_quantity'],
            'image_path' => $imagePath,
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()
            ->route('admin.bouquets.index')
            ->with('success', 'Bouquet updated successfully!');
    }


    // Delete a bouquet.
    public function destroy(PreMadeBouquet $bouquet)
    {
        // Delete the associated image from storage.
        if ($bouquet->image_path) {
            Storage::disk('public')->delete($bouquet->image_path);
        }

        // Delete the bouquet record.
        $bouquet->delete();

        return redirect()
            ->route('admin.bouquets.index')
            ->with('success', 'Bouquet deleted successfully!');
    }
}