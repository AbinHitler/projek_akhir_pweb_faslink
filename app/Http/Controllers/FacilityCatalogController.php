<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FacilityCatalogController extends Controller
{
    public function index(Request $request): View
    {
        $facilities = Facility::with(['parent', 'category'])
            ->where('status', 'aktif')
            ->where('condition', 'baik')
            ->when($request->filled('type'), fn ($q) => $q->where('type', (string) $request->input('type')))
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%'.(string) $request->input('search').'%'))
            ->orderBy('type')->orderBy('name')->paginate(12)->withQueryString();

        return view('user.catalog', ['facilities' => $facilities, 'role' => 'user']);
    }

    public function show(Facility $facility): View
    {
        abort_unless($facility->status === 'aktif' && $facility->condition === 'baik', 404);
        return view('user.facility-detail', ['facility' => $facility->load(['parent', 'category']), 'role' => 'user']);
    }
}
