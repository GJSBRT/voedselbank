<?php

namespace App\Http\Controllers;

use App\Classes\Role;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $permission = Role::checkPermission($request->user(), 'categories:read');
        if ($permission) { return $permission; }

        $category = ProductCategory::where('name', '!=', 'deleted')->paginate();
        return Inertia::render("ProductCategory/Show", [
            'category' => $category,
        ]);
    }

    public function new(Request $request)
    {
        $permission = Role::checkPermission($request->user(), 'categories:create');
        if ($permission) { return $permission; }

        return Inertia::render("ProductCategory/New");
    }

    public function create(CreateCategoryRequest $request)
    {
        $permission = Role::checkPermission($request->user(), 'categories:create');
        if ($permission) { return $permission; }

        ProductCategory::create([
            'name' => $request->input('name')
        ]);

        $request->session()->flash('flash.banner', 'Categorie toegevoegd');

        return redirect()->route('categories.index');
    }

    public function view($categoryId, Request $request)
    {
        $permission = Role::checkPermission($request->user(), 'categories:update');
        if ($permission) { return $permission; }

        // Try to get the category, else gives a 404 back.
        $category = ProductCategory::where('id', $categoryId)->firstOrFail();

        $category = ProductCategory::where('id', $categoryId,)->firstOrFail();

        return Inertia::render('ProductCategory/View', [
            'category' => $category
        ]);
    }

    public function update(UpdateCategoryRequest $request, $categoryId)
    {
        $permission = Role::checkPermission($request->user(), 'categories:update');
        if ($permission) { return $permission; }

        $category = ProductCategory::where('id', $categoryId)->firstOrFail();
        $name = $request->all();
        $category->fill($name)->save();

        return redirect()->route('categories.index')->banner('Categorie is gewijzigd');
    }

    public function delete($categoryId, Request $request)
    {
        $permission = Role::checkPermission($request->user(), 'categories:delete');
        if ($permission) { return $permission; }

        //search the customer you want to delete
        //Because of customer preference there will be a soft delete
        $category = ProductCategory::where('id', $categoryId)->firstOrFail();
        $category->update([
            'name' => 'deleted',
        ]);

        return redirect()->route('categories.index')->banner('Categorie is succesvol verwijderd');

    }
}
