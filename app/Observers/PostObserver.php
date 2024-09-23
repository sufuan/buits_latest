<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "updated" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        if ($post->isDirty('post_status') && $post->post_status == 'published') {
            $user = $post->user;
            if ($user->usertype == 'user') {
                $user->usertype = 'volunteer';
                $user->save();
            }
        }
    }
}
