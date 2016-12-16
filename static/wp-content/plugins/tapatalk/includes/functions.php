<?php

function ttwp_config()
{
    global $wp_version, $tapatalk;

    $response = array(
        'version' => $tapatalk->version,
        'wp_version' => $wp_version,
        'tag_count' => wp_count_terms('post_tag'),
        'blog_count' => tt_get_post_count(),
    );

    tt_json_response($response);
}

function ttwp_category()
{
    $categories = get_terms('category');

    $response = array();
    foreach ($categories as $category)
    {
        $response[$category->term_id] = array(
            'cat_id'    => $category->term_id,
            'name'      => $category->name,
            'count'     => $category->count,
            'parent'    => $category->parent,
        );
    }

    do {
        $category_num_start = count($response);
        foreach($response as $cat_id => &$category)
        {
            $is_leaf = true;
            foreach($response as $category_tmp)
            {
                if ($cat_id == $category_tmp['parent'])
                {
                    $is_leaf = false;
                    break;
                }
            }

            if ($is_leaf && isset($response[$category['parent']]))
            {
                $response[$category['parent']]['child'][] = $category;
                unset($response[$cat_id]);
            }
        }
        $category_num_end = count($response);
    } while($category_num_start > $category_num_end);

    tt_json_response(array_values($response));
}

function ttwp_tag()
{
    $tags = get_terms('post_tag');

    $response = array();
    foreach ($tags as $tag)
    {
        $response[$tag->term_id] = array(
            'tag_id'    => $tag->term_id,
            'name'      => $tag->name,
            'count'     => $tag->count,
            'parent'    => $tag->parent,
        );
    }

    tt_json_response(array_values($response));
}

function ttwp_plugin(){
    if ( ! function_exists( 'get_plugins' ) ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $plugins = get_plugins();

    $response = array();
    foreach($plugins as $key => $plugin){
        $response[] = array(
            'name' => $plugin['Name'],
            'plugin_url' => $plugin['PluginURI'],
            'version' => $plugin['Version'],
            'author_name' => $plugin['AuthorName'],
            'author_uri' => $plugin['AuthorURI'],
            'active' => is_plugin_active( $key ),
        );
    }

    tt_json_response(array_values($response));
}

function ttwp_blogs()
{
    global $wp_query, $post, $wpdb, $tt_timestamp_filter, $tt_post_types;

    $args = array(
        'offset'                => isset($_GET['page']) ? ($_GET['page'] - 1) * (isset($_GET['perpage']) ? $_GET['perpage'] : 20) : 0,
        'posts_per_page'        => isset($_GET['perpage']) ? $_GET['perpage'] : 20,
        'cat'                   => isset($_GET['category']) ? $_GET['category'] : '',
        'tag_id'                => isset($_GET['tag']) ? $_GET['tag'] : '',
        'ignore_sticky_posts'   => true,
    );

    $tt_timestamp_filter = isset($_GET['newer']) ? intval($_GET['newer']) : 0;

    if ($tt_timestamp_filter)
    {
        add_filter('posts_where', 'tt_add_timestamp_filter', 10, 2);
    }

    if (post_type_exists('xda-external-link')){
        $tt_post_types = array('post', 'xda-external-link');
        add_filter('posts_where', 'tt_add_post_type_filter', 10, 2);
    }

    $myposts = $wp_query->query($args);

    $image_preview_type = isset($_GET['preview']) ? $_GET['preview'] : 'full';

    // fix compatibility issue with plugin 'monarch'
    global $wp_filter;
    if (isset($wp_filter['the_content']))
    {
        foreach($wp_filter['the_content'] as $index => $functions)
        {
            foreach($functions as $fname => $function)
            {
                if (isset($function['function']) && is_array($function['function']) && is_object($function['function'][0]) && get_class($function['function'][0]) == 'ET_Monarch')
                    unset($wp_filter['the_content'][$index][$fname]);
            }
        }
    }

    $response_posts = array();
    foreach( $myposts as $post )
    {
        setup_postdata($post);
        $post = get_post();

        $authordata = get_userdata($post->post_author);
        $content_ori = get_the_content(false);
        $content_ori = tt_process_content($content_ori, true);
        $content = apply_filters( 'the_content', $content_ori );
        $content = tt_process_html_content($content);
        $content = str_replace( ']]>', ']]&gt;', $content );
        $content = strip_tags($content);

        // get the first image associated with the post
        $image_url = '';
        $first_image = null;
        $args2 = array( 'post_type' => 'attachment', 'posts_per_page' => -1, 'order'=> 'ASC', 'post_mime_type' => 'image', 'post_parent' => $post->ID );
        $attachments = get_posts($args2);
        foreach ($attachments as $attachment){
            if (strstr($content_ori, $attachment->guid)){
                $first_image = $attachment;
                break;
            }
        }

        if (!empty($first_image))
        {
            switch ($image_preview_type)
            {
                case 'thumbnail':
                    $image_src = wp_get_attachment_image_src($first_image->ID, 'thumbnail');
                    if ($image_src) break;
                case 'full':
                    $image_src = wp_get_attachment_image_src($first_image->ID, 'full');
                    break;
            }

            if (is_array($image_src) && !empty($image_src))
                $image_url = $image_src[0];
        }

        $categories = wp_get_post_categories($post->ID, array('fields' => 'all_with_object_id'));
        $response_category = array();
        foreach($categories as $category)
        {
            $response_category[] = array(
                'cat_id'    => $category->term_id,
                'name'      => $category->name,
                'count'     => $category->count,
                'parent'    => $category->parent,
            );
        }

        $tags = get_the_tags($post->ID);
        $response_tag = array();
        if (!empty($tags)){
            foreach($tags as $tag){
                $response_tag[] = array(
                    'tag_id' => $tag->term_id,
                    'name' => $tag->name,
                    'count' => $tag->count,
                    'parent' => $tag->parent,
                );
            }
        }
        $comment_count = 0;
        if(tt_isDisqusEnabled())
        {
            $dsq = new DisqusAPI(get_option('disqus_user_api_key'),get_option('disqus_api_key'));
            if (($dsq_thread = $dsq->get_thread_by_url($post->guid)) === false)
            {
                throw new Exception($dsq->get_last_error());
            }
            $comment_count = isset($dsq_thread->num_comments) ? $dsq_thread->num_comments : 0;
        }
        else
        {
            $comment_count = get_comments('count=1&type=comment&status=approve&post_id='.$post->ID);
        }
        $response_post = array(
            'blog_id'       => $post->ID,
            'title'         => tt_post_html_clean($post->post_title),
            'timestamp'     => strtotime($post->post_date_gmt),
            'preview'       => tt_process_short_content($content),
            'preview_image' => $image_url,
            'author'        => array(
                                   'user_id' => intval($authordata->ID),
                                   'name'    => empty($authordata->display_name) ? '' : $authordata->display_name,
                'avatar'  => tt_get_avatar_by_uid($authordata->ID),
            ),
            'status'        => $post->post_status,
            'password'      => post_password_required(),
            'comment_count' => $comment_count,
            'category'      => $response_category,
            'tag'           => $response_tag,
        );

        if ($post->post_type == 'xda-external-link'){
            $response_post['type'] = 'link';
            $response_post['link'] = html_entity_decode(get_post_meta($post->ID, 'wpcf-link', true), ENT_QUOTES, 'UTF-8');
        }
        $response_posts[] =$response_post;
    }
    unset($post);

    $response = array(
        'total' => tt_get_post_count(isset($_GET['category']) ? $_GET['category'] : '', $tt_timestamp_filter),
        'blogs' => $response_posts,
    );

    tt_json_response($response);
}

function ttwp_blog()
{
    global $post;

    $file = substr(__FILE__, stripos(__FILE__, 'tapatalk'));
    if (!isset($_GET['blog_id']) || empty($_GET['blog_id'])){
        tt_json_error(-32602, '', array('file' => $file, 'line' => __LINE__, 'params' => $_GET));
    }

    $response = array();

    $blog_id = intval($_GET['blog_id']);
    $post = get_post($blog_id);

    if (empty($post) || empty($post->ID)){
        tt_json_error(-32602, '', array('file' => $file, 'line' => __LINE__, 'params' => $_GET));
    }

    $post->post_content = preg_replace('/<!--more(.*?)?-->/', '', $post->post_content);
    setup_postdata($post);
    $authordata = get_userdata($post->post_author);

    $categories = wp_get_post_categories($post->ID, array('fields' => 'all_with_object_id'));
    $response_category = array();
    foreach($categories as $category)
    {
        $response_category[] = array(
            'cat_id'    => $category->term_id,
            'name'      => $category->name,
            'count'     => $category->count,
            'parent'    => $category->parent,
        );
    }

    $tags = get_the_tags($blog_id);
    $response_tag = array();
    if (!empty($tags)){
        foreach($tags as $tag){
            $response_tag[] = array(
                'tag_id' => $tag->term_id,
                'name' => $tag->name,
                'count' => $tag->count,
                'parent' => $tag->parent,
            );
        }
    }

    $prev_blog = get_adjacent_post();
    $next_blog = get_adjacent_post(false, '', false);
    $content = get_the_content();
    $content = tt_process_content($content, false);
    $content = apply_filters( 'the_content', $content );
    $content = tt_process_html_content($content);
    $content = str_replace( ']]>', ']]&gt;', $content );
    $comment_count = 0;
    if(tt_isDisqusEnabled())
    {
        $dsq = new DisqusAPI(get_option('disqus_user_api_key'),get_option('disqus_api_key'));
        if (($dsq_thread = $dsq->get_thread_by_url($post->guid)) === false)
        {
            throw new Exception($dsq->get_last_error());
        }
        $comment_count = isset($dsq_thread->num_comments) ? $dsq_thread->num_comments : 0;
    }
    else
    {
        $comment_count = get_comments('count=1&type=comment&status=approve&post_id='.$blog_id);
    }
    $response_blog = array(
        'blog_id'       => $post->ID,
        'title'         => tt_post_html_clean($post->post_title),
        'timestamp'     => strtotime($post->post_date_gmt),
        'content'       => tt_post_html_clean($content),
        'author'        => array(
                               'user_id' => intval($authordata->ID),
                               'name'    => empty($authordata->display_name) ? '' : $authordata->display_name,
            'avatar'  => tt_get_avatar_by_uid($authordata->ID),
        ),
        'status'        => $post->post_status,
        'password'      => post_password_required(),
        'comment_count' => $comment_count,
        'category'      => $response_category,
        'tag'           => $response_tag,
        'prev'          => isset($prev_blog->ID) ? $prev_blog->ID : 0,
        'prev_title'    => isset($prev_blog->post_title) ? tt_post_html_clean($prev_blog->post_title) : '',
        'next'          => isset($next_blog->ID) ? $next_blog->ID : 0,
        'next_title'    => isset($next_blog->post_title) ? tt_post_html_clean($next_blog->post_title) : '',
    );

    if ($post->post_type == 'xda-external-link'){
        $response_blog['type'] = 'link';
        $response_blog['link'] = html_entity_decode(get_post_meta($post->ID, 'wpcf-link', true), ENT_QUOTES, 'UTF-8');
    }

    $response['blog'] = $response_blog;

    if ($comment_count && isset($_GET['perpage']) && $_GET['perpage'] > 0)
    {
        if (isset($_GET['order']) && !empty($_GET['order'])) {
            if (strtolower($_GET['order']) == 'asc'){
                $order = 'ASC';
            } else {
                $order = 'DESC';
            }
        } else {
            $order = get_option('comment_order');
        }

        $response_comments = array();
        if(tt_isDisqusEnabled() && isset($dsq) && isset($dsq_thread))
        {
            $args = array('exclude'=>'spam,killed','limit'=>$_GET['perpage'], 'start' => 0);
            $comments = $dsq->get_thread_posts($dsq_thread->id, $args);

            foreach($comments as $comment)
            {
                $response_comments[] = array(
                    'comment_id'    => $comment->id,
                    'timestamp'     => strtotime($comment->created_at),
                    'content'       => $comment->message,
                    'author'        => array(
                        'user_id' => $comment->author->id,
                        'name'    => $comment->author->display_name,
                        'avatar'  => $_SERVER['REQUEST_SCHEME'] .':'. $comment->author->avatar->medium,
                    ),
                    'status'        => $comment->status,
                );
            }
        }
        else
        {
            $args = array(
              'post_id'   => $post->ID,
              'status'    => 'approve',           // approve/hold/spam/trash
              'order'     => $order,
              'number'    => $_GET['perpage'],
              'type'      => 'comment',
              'offset'    => 0,
          );
            $comments = get_comments($args);
            foreach($comments as $comment)
            {
                $response_comments[] = array(
                    'comment_id'    => $comment->comment_ID,
                    'timestamp'     => strtotime($comment->comment_date_gmt),
                    'content'       => $comment->comment_content,
                    'author'        => array(
                                       'user_id' => intval($comment->user_id),
                                       'name'    => empty($comment->comment_author) ? '' : $comment->comment_author,
                        'avatar'  => tt_get_avatar_by_uid($comment->user_id),
                    ),
                    'status'        => $comment->comment_approved,
                );
            }
        }

        $response['commonts'] = $response_comments;
    }

    tt_json_response($response);
}

function ttwp_comments()
{
    global $post;
    $response_comments = array();

    $file = substr(__FILE__, stripos(__FILE__, 'tapatalk'));
    if (!isset($_GET['blog_id']) || empty($_GET['blog_id'])){
        tt_json_error(-32602, '', array('file' => $file, 'line' => __LINE__, 'params' => $_GET));
    }
    $blog_id = intval($_GET['blog_id']);
    $post = get_post($blog_id);

    if (isset($_GET['perpage']) && !empty($_GET['perpage']) && intval($_GET['perpage']) > 0){
        $perpage = intval($_GET['perpage']);
    } else {
        $perpage = 20;
    }

    if (isset($_GET['page']) && !empty($_GET['page']) && intval($_GET['page']) > 0){
        $page = intval($_GET['page']);
    } else {
        $page = 1;
    }

    if (isset($_GET['order']) && !empty($_GET['order'])) {
        if (strtolower($_GET['order']) == 'asc'){
            $order = 'ASC';
        } else {
            $order = 'DESC';
        }
    } else {
        $order = get_option('comment_order');
    }

    if(tt_isDisqusEnabled())
    {
        $dsq = new DisqusAPI(get_option('disqus_user_api_key'),get_option('disqus_api_key'));

        if (($dsq_thread = $dsq->get_thread_by_url($post->guid)) === false)
        {
            throw new Exception($dsq->get_last_error());
        }
        if($total = isset($dsq_thread->num_comments) ? $dsq_thread->num_comments : 0)
        {
            $args = array(
                'exclude'=>'spam,killed',
                'limit'=>$perpage,
                'start' => ($page - 1) * $perpage,
            );
            $comments = $dsq->get_thread_posts($dsq_thread->id, $args);

            foreach($comments as $comment)
            {
                $response_comments[] = array(
                    'comment_id'    => $comment->id,
                    'timestamp'     => strtotime($comment->created_at),
                    'content'       => $comment->message,
                    'author'        => array(
                        'user_id' => $comment->author->id,
                        'name'    => $comment->author->display_name,
                        'avatar'  => $_SERVER['REQUEST_SCHEME'] .':'. $comment->author->avatar->medium,
                    ),
                    'status'        => $comment->status,
                );
            }
        }
    }
    else
    {
        if ($total = get_comments('count=1&type=comment&status=approve&post_id='.$_GET['blog_id']))
        {
            $args = array(
                'post_id'   => $blog_id,
                'status'    => 'approve',           // approve/hold/spam/trash
                'type'      => 'comment',
                'order'     => $order,
                'number'    => $perpage,
                'offset'    => ($page - 1) * $perpage,
            );
            $comments = get_comments($args);

            foreach($comments as $comment)
            {
                $response_comments[] = array(
                    'comment_id'    => $comment->comment_ID,
                    'timestamp'     => strtotime($comment->comment_date_gmt),
                    'content'       => $comment->comment_content,
                    'author'        => array(
                                       'user_id' => intval($comment->user_id),
                                       'name'    => empty($comment->comment_author) ? '' : $comment->comment_author,
                        'avatar'  => tt_get_avatar_by_uid($comment->user_id),
                    ),
                    'parent'        => $comment->comment_parent,
                    'status'        => $comment->comment_approved,
                );
            }
        }
    }

    $response = array(
        'total'     => $total,
        'commonts'  => $response_comments,
    );

    tt_json_response($response);
}

function tt_isDisqusEnabled()
{
    return class_exists('DisqusAPI');
}
/*
function ttwp_login()
{
if(empty($_REQUEST['username']) || empty($_REQUEST['password']))
{
tt_json_error(-32602);
}
$username = trim($_REQUEST['username']);
$password = trim($_REQUEST['password']);
if(!is_user_logged_in())
{
$credentials = array(
'user_login' => $username,
'user_password' => $password,
'remember' => true
);
$user = wp_signon($credentials, false);
if(is_wp_error($user)){
$error_msg = $user->get_error_messages();
tt_json_error(0,strip_tags($error_msg[0]));
}
}
else
{
$user = wp_get_current_user();
}
tt_json_response($user);
}
 */
