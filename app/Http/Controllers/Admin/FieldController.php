<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\FieldType;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index(Request $request)
    {
        $query = Field::with('fieldType');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->field_type_id) {
            $query->where('field_type_id', $request->field_type_id);
        }
        if ($request->status !== null && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        $fields     = $query->latest()->paginate(10)->withQueryString();
        $fieldTypes = FieldType::all();

        return view('admin.fields.index', compact('fields', 'fieldTypes'));
    }

    public function create()
    {
        $fieldTypes = FieldType::all();
        return view('admin.fields.create', compact('fieldTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'field_type_id' => 'required|exists:field_types,id',
            'name'          => 'required|string|max:50',
            'price_offpeak' => 'required|numeric|min:0',
            'price_peak'    => 'required|numeric|min:0',
            'description'   => 'nullable|string|max:1000',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('fields', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        Field::create($data);

        return redirect()->route('admin.fields.index')
            ->with('success', 'Lapangan berhasil ditambahkan!');
    }

    public function show(Field $field)
    {
        $field->load('fieldType', 'bookings');
        return view('admin.fields.show', compact('field'));
    }

    public function edit(Field $field)
    {
        $fieldTypes = FieldType::all();
        return view('admin.fields.edit', compact('field', 'fieldTypes'));
    }

    public function update(Request $request, Field $field)
    {
        $data = $request->validate([
            'field_type_id' => 'required|exists:field_types,id',
            'name'          => 'required|string|max:50',
            'price_offpeak' => 'required|numeric|min:0',
            'price_peak'    => 'required|numeric|min:0',
            'description'   => 'nullable|string|max:1000',
            'photo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('fields', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        $field->update($data);

        return redirect()->route('admin.fields.index')
            ->with('success', 'Lapangan berhasil diperbarui!');
    }

    public function destroy(Field $field)
    {
        $field->delete();

        return redirect()->route('admin.fields.index')
            ->with('success', 'Lapangan berhasil dihapus!');
    }
}
