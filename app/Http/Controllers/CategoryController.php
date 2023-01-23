<?php

namespace App\Http\Controllers;

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
        $category = ProductCategory::where('name', '!=', 'deleted')->paginate();
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

        return redirect()->route('categories.index');
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

        return redirect()->route('categories.index');
    }

    public function delete(int $categoryId)
    {
        //search the customer you want to delete
        //Because of customer preference there will be a soft delete
        $customer = ProductCategory::all()->find($categoryId);
        $customer->update([
            'name' => 'deleted',
        ]);

        return redirect()->route('categories.index')->banner('Categorie is succesvol verwijderd');

    }
}
