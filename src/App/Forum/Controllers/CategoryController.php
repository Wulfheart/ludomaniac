<?php

namespace App\Forum\Controllers;

use App\Forum\ViewModels\Category\ShowAllCategoriesViewModel;
use App\Forum\ViewModels\Structs\CategoryStruct;
use Domain\Forum\Models\Category;
use Support\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()->orderBy('position')->get()->map(fn (Category $category) => CategoryStruct::fromCategory($category));

        return view('forum.category.index', new ShowAllCategoriesViewModel($categories->toArray()));
    }

    public function show(Category $category)
    {
        //
    }
}
