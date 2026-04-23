<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\FieldType;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $fieldTypes = FieldType::withCount(['fields' => function ($q) {
            $q->where('is_active', true);
        }])->get();

        $query = Field::with('fieldType')->where('is_active', true);

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->field_type_id) {
            $query->where('field_type_id', $request->field_type_id);
        }

        if ($request->price_max) {
            $query->where('price_offpeak', '<=', $request->price_max);
        }

        $fields      = $query->paginate(9)->withQueryString();
        $totalFields = Field::where('is_active', true)->count();

        return view('landing', compact('fields', 'fieldTypes', 'totalFields'));
    }
}
