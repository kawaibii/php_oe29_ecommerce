<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Auth;
use PHPUnit\Exception;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('viewAny', Category::class)) {
            $categories = Category::all();
            $parents = Category::where('parent_id', null)->get();

            return view('admin.categories.list', compact('categories', 'parents'));
        }

        return abort(config('setting.errors404'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        if (Auth::user()->can('create', Category::class)) {
            if ($request->parent_id == null) {
                $category = Category::create([
                    'name' => $request->name,
                    'parent_id' => null,
                ]);
            } else {
                try {
                    $parent = Category::findOrFail($request->parent_id);
                    $category = Category::create([
                        'name' => $request->name,
                        'parent_id' => $parent->id,
                    ]);
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }

            return redirect()->back();
        }

        return abort(config('setting.errors404'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        if (Auth::user()->can('update', Category::class)) {
            try {
                $category = Category::findOrFail($id);
                if ($request->parent_id == null) {
                    $category->update([
                        'name' => $request->name,
                        'parent_id' => null,
                    ]);
                } else {
                    $parent = Category::findOrFail($request->parent_id);
                    $category->update([
                        'name' => $request->name,
                        'parent_id' => $request->parent_id,
                    ]);
                }

                return redirect()->back();
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        return abort(config('setting.errors404'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('delete', Category::class)) {
            try {
                $parentCategory = Category::findOrFail($id);
                $categories = Category::with('children')->findOrFail($id);
                foreach ($categories->children as $child) {
                    $child->update([
                        'parent_id' => null,
                    ]);
                }
                $parentCategory->delete();

                return redirect()->back();
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }
}
