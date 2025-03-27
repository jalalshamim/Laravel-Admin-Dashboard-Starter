<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::latest()->get();
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'meta_title' => 'nullable|max:255',
                'meta_description' => 'nullable|max:255',
                'meta_keywords' => 'nullable|max:255',
                'is_active' => 'required|in:0,1'
            ]);

            $validated['slug'] = Str::slug($validated['title']);

            $page = new Page($validated);
$page->is_active = $request->boolean('is_active');

            if ($request->hasFile('featured_image')) {
                $path = $request->file('featured_image')->store('pages', 'public');
                $page->featured_image = $path;
            }

            $page->save();
            
            Session::flash('success', 'Page created successfully!');
            return redirect()->route('admin.pages.index');
        } catch (\Exception $e) {
            Log::error('Page creation error: ' . $e->getMessage());
            Session::flash('error', 'Page creation failed: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
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
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:255',
            'meta_keywords' => 'nullable|max:255',
            'is_active' => 'required|in:0,1'
        ]);

        $page->title = $validated['title'];
        $page->slug = Str::slug($validated['title']);
        $page->content = $validated['content'];
        $page->meta_title = $validated['meta_title'];
        $page->meta_description = $validated['meta_description'];
        $page->meta_keywords = $validated['meta_keywords'];
        $page->is_active = $request->boolean('is_active', true);

        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($page->featured_image) {
                Storage::disk('public')->delete($page->featured_image);
            }
            $path = $request->file('featured_image')->store('pages', 'public');
            $page->featured_image = $path;
        }

        $page->save();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        if ($page->featured_image) {
            Storage::disk('public')->delete($page->featured_image);
        }
        
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }

    public function toggleStatus(Page $page)
    {
        $page->is_active = !$page->is_active;
        $page->save();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page status updated successfully.');
    }
}
