<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\FieldType;
use Illuminate\Http\Request;

class FieldCatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Field::with('fieldType')->where('is_active', true);

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->field_type_id) {
            $query->where('field_type_id', $request->field_type_id);
        }

        $fields     = $query->paginate(9)->withQueryString();
        $fieldTypes = FieldType::all();

        return view('user.fields.index', compact('fields', 'fieldTypes'));
    }

    public function show(Field $field)
    {
        abort_if(!$field->is_active, 404);
        $field->load('fieldType');
        return view('user.fields.show', compact('field'));
    }
}
