<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuItemController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created menu item.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu_id' => 'required|exists:menus,id',
            'parent_id' => [
                'nullable',
                'exists:menu_items,id',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $parent = MenuItem::find($value);
                        if ($parent && $parent->depth >= 2) {
                            $fail('Maximum nesting level of 3 exceeded.');
                        }
                    }
                },
            ],
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:2048',
            'icon' => 'nullable|string|max:50',
            'target' => 'required|in:_self,_blank',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $menuItem = MenuItem::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Menu item created successfully',
            'item' => $menuItem
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the menu item.
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:2048',
            'icon' => 'nullable|string|max:50',
            'target' => 'required|in:_self,_blank',
            'status' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $menuItem->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Menu item updated successfully',
            'item' => $menuItem
        ]);
    }

    /**
     * Update menu items order.
     */
    public function reorder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*.id' => 'required|exists:menu_items,id',
            'items.*.parent_id' => 'nullable|exists:menu_items,id',
            'items.*.order' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        foreach ($request->items as $item) {
            $menuItem = MenuItem::find($item['id']);
            
            // Check depth limit
            if (isset($item['parent_id'])) {
                $parent = MenuItem::find($item['parent_id']);
                if ($parent && $parent->depth >= 2) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Maximum nesting level of 3 exceeded.'
                    ], 422);
                }
            }

            $menuItem->update([
                'parent_id' => $item['parent_id'],
                'order' => $item['order'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Menu items reordered successfully'
        ]);
    }

    /**
     * Remove the menu item.
     */
    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Menu item deleted successfully'
        ]);
    }
}
