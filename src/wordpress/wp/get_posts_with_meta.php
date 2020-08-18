<?php

namespace ue\wp;

trait wp_get_posts_with_meta {

    
    public static function wp_get_posts_with_meta($args)
    {

        $posts = get_posts($args);

        foreach($posts as $key => $post)
        {
            $result[$key]['post'] = $post;
            $result[$key]['meta'] = get_post_meta($post->ID);
        }


        return $result;
    }

}