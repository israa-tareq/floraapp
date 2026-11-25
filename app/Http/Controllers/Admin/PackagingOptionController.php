<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackagingOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PackagingOptionController extends Controller
{
    // Display all packaging options.
    public function index()
    {
        $packagingOptions = PackagingOption::latest()->paginate(10);

        return view('admin.packaging.index', compact('packagingOptions'));
    }


    // Display the form for creating a packaging option.
    public function create()
    {
        return view('admin.packaging.create');
    }


    // Save a new packaging option.
    public function store(Request $request)
    {
        // Validate the submitted form.
        $validated = $request->validate([
            'type' => [
                'required',
                Rule::in(['wrap', 'ribbon', 'box']),
            ],
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Store the uploaded image.
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')
                ->store('packaging', 'public');
        }

        // Create the packaging option in the database.
        PackagingOption::create([
            'type' => $validated['type'],
            'name' => $validated['name'],
            'color' => $validated['color'],
            'price' => $validated['price'],
            'stock_quantity' => $validated['stock_quantity'],
            'image_path' => $validated['image_path'] ?? null,
        ]);

        return redirect()
            ->route('admin.packaging.index')
            ->with('success', 'Packaging option added successfully!');
    }


    // Display the form for editing a packaging option.
    public function edit(PackagingOption $packaging)
    {
        return view('admin.packaging.edit', compact('packaging'));
    }


    // Update an existing packaging option.
    public function update(Request $request, PackagingOption $packaging)
    {
        // Validate the submitted form.
        $validated = $request->validate([
            'type' => [
                'required',
                Rule::in(['wrap', 'ribbon', 'box']),
            ],
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Keep the current image unless a new image is uploaded.
        $imagePath = $packaging->image_path;

        if ($request->hasFile('image')) {

            // Store the new image.
            $imagePath = $request->file('image')
                ->store('packaging', 'public');

            // Delete the old image.
            if ($packaging->image_path) {
                Storage::disk('public')->delete($packaging->image_path);
            }
        }

        // Update the packaging option information.
        $packaging->update([
            'type' => $validated['type'],
            'name' => $validated['name'],
            'color' => $validated['color'],
            'price' => $validated['price'],
            'stock_quantity' => $validated['stock_quantity'],
            'image_path' => $imagePath,
        ]);

        return redirect()
            ->route('admin.packaging.index')
            ->with('success', 'Packaging option updated successfully!');
    }


    // Delete a packaging option.
    public function destroy(PackagingOption $packaging)
    {
        // Delete the associated image from storage.
        if ($packaging->image_path) {
            Storage::disk('public')->delete($packaging->image_path);
        }

        // Delete the packaging option record.
        $packaging->delete();

        return redirect()
            ->route('admin.packaging.index')
            ->with('success', 'Packaging option deleted successfully!');
    }
}