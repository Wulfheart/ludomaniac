<?php

namespace App\Forum\ViewModels\Category;

use App\Forum\ViewModels\Structs\CategoryStruct;

class ShowAllCategoriesViewModel
{
    /**
     * @param  array<CategoryStruct>  $categories
     */
    public function __construct(
        public array $categories,
    ) {
    }
}
