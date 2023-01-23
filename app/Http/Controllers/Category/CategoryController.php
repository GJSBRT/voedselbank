<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $category = ProductCategory::paginate();
        return Inertia::render("ProductCategory/Show", [
            'category' => $category,
        ]);
    }

    public function new()
    {
        return Inertia::render("ProductCategory/New");
    }

    public function create(CreateCategoryRequest $request)
    {
        $category = ProductCategory::create([
            'name' => $request->input('name')
        ]);

        $request->session()->flash('flash.banner', 'Categorie toegevoegd');

        return redirect()->route('category.index');
    }

    public function view(int $categoryId)
    {
        $category = ProductCategory::all()->find($categoryId);

        return Inertia::render('ProductCategory/View', [
            'category' => $category
        ]);
    }

    public function update(UpdateCategoryRequest $request, int $categoryId)
    {
        $category = ProductCategory::all()->find($categoryId);
        $name = $request->all();
        $category->fill($name)->save();

        $request->session()->flash('flash.banner', 'Categorie gewijzigd');

        return redirect()->route('category.index');
    }

    public function delete(int $categoryId)
    {
        $category = ProductCategory::all()->find($categoryId);

        //What needs to be deleted? All data that is bound by category or same as customer?

        return redirect()->route('customer.index')->banner('Klant is succesvol verwijderd');
    }
}
