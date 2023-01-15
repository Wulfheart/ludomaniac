<?php

namespace App\Forum\Controllers;

use App\Forum\Requests\PostRequest;
use Domain\Forum\Actions\CreatePostAction;
use Domain\Forum\Actions\EditPostAction;
use Domain\Forum\Models\Category;
use Domain\Forum\Models\Post;
use Domain\Forum\Models\Thread;
use Illuminate\Http\RedirectResponse;
use Support\Controllers\Controller;

class PostController extends Controller
{
    public function __construct(
        protected CreatePostAction $createPostAction,
        protected EditPostAction $editPostAction,
    ) {
    }

    public function create(Category $category, Thread $thread)
    {
        //
    }

    public function store(Category $category, Thread $thread, PostRequest $request): RedirectResponse
    {
        $this->createPostAction->execute($thread, $request->user(), $request->get('body'));

        return redirect()->route('forum.thread.show', [$category, $thread]);
    }

    public function edit(Post $post)
    {
        //
    }

    public function update(Post $post, PostRequest $request)
    {
        $this->editPostAction->execute($post, $request->get('body'));
    }

    public function destroy(Post $post)
    {
        //
    }
}
