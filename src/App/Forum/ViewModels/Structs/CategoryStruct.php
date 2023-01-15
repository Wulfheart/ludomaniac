<?php

namespace App\Forum\ViewModels\Structs;

use Domain\Forum\Models\Category;

class CategoryStruct
{
    public function __construct(
        public string $link,
        public string $name,
        public string $description,
        public PostStruct $latestPost
    ) {
    }

    public function fromCategory(Category $category): self
    {
        return new self(
            link:route(''),
            name: $category->name,
            description: $category->description,
            latestPost: PostStruct::fromPost($category->latestPost),
        );
    }
}
