<?php

namespace App\Forum\Controllers;

use App\Forum\Requests\ThreadRequest;
use Domain\Forum\Models\Category;
use Domain\Forum\Models\Thread;
use Support\Controllers\Controller;

class ThreadController extends Controller
{
    public function show(Category $category, Thread $thread)
    {
        //
    }

    public function create(Category $category, Thread $thread)
    {
        //
    }

    public function store(Category $category, Thread $thread, ThreadRequest $request)
    {
        //
    }
}
