<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courier;

class CourierController extends Controller
{
    /**
     * GET /api/couriers
     */
    public function index(Request $request)
    {
        $query = Courier::query();

        // Search by name (support multi word)
        if ($search = $request->query('search')) {
            $keywords = explode(' ', $search);
            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->where('name', 'like', '%' . $word . '%');
                }
            });
        }

        // Filter by level (example: ?level=2,3)
        if ($levels = $request->query('level')) {
            $levelArray = explode(',', $levels);
            $query->whereIn('level', $levelArray);
        }

        // Sorting
        $sortBy = $request->query('sort_by', 'name');

        if ($sortBy === 'joined_at') {
            $query->orderBy('joined_at');
        } else {
            $query->orderBy('name');
        }

        return response()->json(
            $query->paginate(2)
        );
    }

    /**
     * POST /api/couriers
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:couriers,email',
            'phone' => 'required|string|max:20',
            'vehicle_type' => 'nullable|string|max:100',
            'vehicle_plate' => 'nullable|string|max:20',
            'level' => 'required|integer|between:1,5',
            'joined_at' => 'required|date',
        ]);

        $courier = Courier::create($validated);

        return response()->json($courier, 201);
    }

    /**
     * GET /api/couriers/{id}
     */
    public function show($id)
    {
        $courier = Courier::find($id);
        if (!$courier) {
            return response()->json([
                'message' => 'Courier not found'
            ], 404);
        }
        return response()->json($courier);
    }

    /**
     * PUT /api/couriers/{id}
     */
    public function update(Request $request, $id)
    {
        $courier = Courier::find($id);
        if (!$courier) {
            return response()->json([
                'message' => 'Courier not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:couriers,email,',
            'phone' => 'sometimes|required|string|max:20',
            'vehicle_type' => 'nullable|string|max:100',
            'vehicle_plate' => 'nullable|string|max:20',
            'level' => 'sometimes|required|integer|between:1,5',
            'joined_at' => 'sometimes|required|date',
        ]);

        $courier->update($validated);

        return response()->json($courier);
    }

    /**
     * DELETE /api/couriers/{id}
     */
    public function destroy($id)
    {
        $courier = Courier::find($id);
        if (!$courier) {
            return response()->json([
                'message' => 'Courier not found'
            ], 404);
        }
        $courier->delete();

        return response()->json([
            'message' => 'Courier deleted successfully'
        ]);
    }
}
