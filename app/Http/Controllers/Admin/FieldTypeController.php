<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FieldType;
use Illuminate\Http\Request;

class FieldTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = FieldType::withCount('fields');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $fieldTypes = $query->latest()->paginate(10)->withQueryString();

        return view('admin.field-types.index', compact('fieldTypes'));
    }

    public function create()
    {
        return view('admin.field-types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50|unique:field_types,name',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('field-types', 'public');
        }

        FieldType::create($data);

        return redirect()->route('admin.field-types.index')
            ->with('success', 'Jenis lapangan berhasil ditambahkan!');
    }

    public function show(FieldType $fieldType)
    {
        $fieldType->load('fields');
        return view('admin.field-types.show', compact('fieldType'));
    }

    public function edit(FieldType $fieldType)
    {
        return view('admin.field-types.edit', compact('fieldType'));
    }

    public function update(Request $request, FieldType $fieldType)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50|unique:field_types,name,' . $fieldType->id,
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('field-types', 'public');
        }

        $fieldType->update($data);

        return redirect()->route('admin.field-types.index')
            ->with('success', 'Jenis lapangan berhasil diperbarui!');
    }

    public function destroy(FieldType $fieldType)
    {
        if ($fieldType->fields()->count() > 0) {
            return redirect()->route('admin.field-types.index')
                ->with('error', 'Tidak bisa dihapus, masih ada lapangan bertipe ini.');
        }

        $fieldType->delete();

        return redirect()->route('admin.field-types.index')
            ->with('success', 'Jenis lapangan berhasil dihapus!');
    }
}
