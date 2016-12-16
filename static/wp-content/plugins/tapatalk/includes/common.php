<?php

function tt_json_error($code, $message = '', $data = array())
{
    $default = array(
        '1'      => 'Failed opening required file',
        '-32700' => 'Parse error',
        '-32600' => 'Invalid Request',
        '-32601' => 'Method not found',
        '-32602' => 'Invalid params',
        '-32603' => 'Internal error',
    );

    if (isset($default[$code])) $message = $default[$code];

    $error = array(
        'code'      => $code,
        'message'   => $message,
    );

    if ($data) $error['data'] = $data;

    tt_json_response($error, 0);
}

function tt_json_response($data, $type = 1)
{
    $response = array();

    if ($type === 0) {
        $response['error'] = $data;
    } else {
        $response['result'] = $data;
    }

    @ob_clean();
    @header('Content-type: application/json; charset=UTF-8', true, 200);
    echo tt_json_encode($response);
    exit;
}

function tt_get_avatar_by_uid($uid)
{
    if (empty($uid)) return '';

    $avatar = preg_replace("/^.*src=['\"]([^'\"]*?)['\"].*$/", '$1', get_avatar($uid));
    $avatar = html_entity_decode($avatar, ENT_QUOTES, 'UTF-8');
    return $avatar;
}

function tt_process_content($content, $is_preview = false){
    global $wpdb;

    $new_content = $content;
    $temp_content = $new_content;
    try{
        $limit = 10;
        $plugins = array();

        if ( file_exists(ABSPATH . 'wp-admin/includes/plugin.php') && ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        if (function_exists( 'get_plugins' )){
            $plugins = get_plugins();
        }

        try{
            $temp_content = preg_replace('/\[embed\]([^\[]+?)\[\/embed\]/', '[url]$1[/url]',$new_content);
            $new_content = $temp_content;
        } catch (Exception $e) {
            $temp_content = $new_content;
        }

        // fix compatibility issue with plugin 'photo gallery'
        try{
            if (isset($plugins['photo-gallery/photo-gallery.php']) && is_plugin_active( 'photo-gallery/photo-gallery.php' )){
                $regular = '/(\[Best_Wordpress_Gallery\s*id\s*=\s*[\'"])(\d+)([^\]]*?gal_title\s*=\s*[\'"])([^\'"]*?)([\'"][^\]]*?\])/i';
                if (preg_match($regular, $new_content, $match)){
                    $replace = '';
                    try{
                        $result = $wpdb->get_results("SHOW TABLES LIKE '{$wpdb->prefix}bwg_image'");
                        if (!$is_preview && !empty($result)){
                            if ($wpdb->query("SHOW TABLES LIKE '" . $wpdb->prefix . "bwg_option'")) {
                                $WD_BWG_UPLOAD_DIR = $wpdb->get_var($wpdb->prepare('SELECT images_directory FROM ' . $wpdb->prefix . 'bwg_option WHERE id="%d"', 1)) . '/photo-gallery';
                            }
                            else {
                                $upload_dir = wp_upload_dir();
                                $WD_BWG_UPLOAD_DIR = str_replace(ABSPATH, '', $upload_dir['basedir']) . '/photo-gallery';
                            }
                            $gallery_id = $match[2];
                            $gallery_title = $match[4];
                            $images = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "bwg_image where gallery_id='" . $gallery_id . "' LIMIT " . $limit);
                            if (empty($images)){
                                $result = $wpdb->get_col("SELECT id FROM " . $wpdb->prefix . "bwg_gallery where name='" . $gallery_title . "'");
                                if(!empty($result)){
                                    $gallery_id = $result[0];
                                }
                                $images = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "bwg_image where gallery_id='" . $gallery_id . "' LIMIT " . $limit);
                            }
                            if (!empty($images)){
                                foreach ($images as $image_row){
                                    $replace .= '[img]' . htmlspecialchars_decode(site_url() . '/' . $WD_BWG_UPLOAD_DIR . $image_row->image_url, ENT_COMPAT | ENT_QUOTES) . '[/img]';
                                }
                            }
                        }
                    } catch (Exception $e) {}
                    $temp_content = preg_replace($regular, $replace, $new_content);
                }

            }
            $new_content = $temp_content;
        } catch (Exception $e) {
            $temp_content = $new_content;
        }
    } catch(Exception $e) {
        $new_content = $content;
    }
    return $new_content;
}

function tt_process_html_content($content){
    $new_content = $content;
    try{
        $new_content = tt_remove_html_paragraph('<div class="sharedaddy sd-sharing-enabled">', 'div', $new_content);
    } catch(Exception $e) {
        $new_content = $content;
    }
    return $new_content;
}

function tt_remove_html_paragraph($search, $tag_type, $str){
    if (strpos($str, $search) === false){
        return $str;
    }
    
    $temp = substr($str, strpos($str, $search) + strlen($search));
    $html_block = $search.tt_search_html_block($temp, $tag_type, $matches);
    $html_block = tt_restore_html_block($html_block, $matches);
    return str_replace($html_block, '', $str);
}

function tt_search_html_block($temp, $tag_type, &$matches = array()){
    $re = "/\<$tag_type((?!\<$tag_type).)*?\<\/$tag_type\>/";
    if (preg_match($re, $temp, $match)){
        $key = 'match_' . md5($match[0]);
        $value = $match[0];
        $matches[$key] = $value;
        $new_temp = str_replace($value, $key, $temp);
        return tt_search_html_block($new_temp, $tag_type, $matches);
    } else {
        return substr($temp, 0, strpos($temp, "</$tag_type>")) . "</$tag_type>";
    }
}

function tt_restore_html_block($string, $matches){
    preg_match_all('/match_[a-f0-9]{32}/', $string, $m);
    foreach ($m as $key => $value){
        $string = str_replace($value[0], $matches[$value[0]], $string);
    }
    if (preg_match('/match_[a-f0-9]{32}/', $string)){
        $string = tt_restore_html_block($string, $matches);
    }
    return $string;
}

function tt_process_short_content($str, $length = 200)
{
    $str = strip_tags($str);
    $str = preg_replace('/\[RSSjb .*?\]/si', '', $str);
    $str = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
    $str = preg_replace('/[\n\r\t\s]+/', ' ', $str);
    $str = preg_replace('/\[url[^\]]*?\][^\[]*?\[\/url\]/', '[url]', $str);
    $str = preg_replace('/\[img[^\]]*?\][^\[]*?\[\/img\]/', '[img]', $str);
    $str = function_exists('mb_substr') ? mb_substr($str, 0, $length) : substr($str, 0, $length);
    return trim($str);
}

function tt_post_html_clean($str)
{
    $str = str_replace("&nbsp;", ' ', $str );
    $str = str_replace("\r\n", '', $str );
    $str = str_replace(array("\r", "\n"), '', $str );
    $str = str_replace("\t", '', $str );
    //$str = preg_replace('/>\s+</si', '><', $str);
    $str = preg_replace('/<p(.*?)>/si', '<br/>', $str);
    $str = str_replace('</p>', '<br/>', $str);
    $str = str_replace('</tr>', '<br/>', $str);
    $str = str_replace('</td>', " ", $str);
    $str = preg_replace('/<ul>/si', '<br/>', $str);
    $str = preg_replace('/<li>/si', '*', $str);
    $str = preg_replace('/<\/li>/si', '<br/>', $str);
    $search = array(
        "/<strong>(.*?)<\/strong>/si",
        "/<em>(.*?)<\/em>/si",
        "/<blockquote>(.*?)<\/blockquote>/si",
        "/<code>(.*?)<\/code>/si",
        "/<img [^>]*?src=\"((?:http|\/).*?)\".*?\/?>/si",
        "/<img [^>]*?data-src=\"((?:http|\/).*?)\".*?\/?>/si",
        "/<img [^>]*?src=\"(.*?)\".*?\/?>/si",
        "/<a [^>]*?href=\"(.*?)\".*?>(.*?)<\/a>/si",
        "/<script( [^>]*)?>([^<]*?)<\/script>/si",
        "/<noscript( [^>]*)?>([^<]*?)<\/noscript>/si",
        "/<br(.*?)\/?>/si",
        "/<h[1-6]>(.*?)<\/h[1-6]>/",
    );

    $replace = array(
        '<b>$1</b>',
        '<i>$1</i>',
        '[quote]$1[/quote]',
        '[quote]$1[/quote]',
        '[img]$1[/img]',
        '[img]$1[/img]',
        '[img]$1[/img]',
        '[url=$1]$2[/url]',
        '',
        '',
        '<br>',
        '<b>$1</b>',
    );

    $str = preg_replace($search, $replace, $str);
    $str = preg_replace('/(\[img\])(\/.+?)(\[\/img\])/', '$1' . site_url() . '$2$3', $str);
    $str = strip_tags($str, '<br><i><b><u>');

    $str = str_replace("&lt;", '=S=temp=B=', $str );
    $str = str_replace("&gt;", '=B=temp=S=', $str );

    $str = html_entity_decode($str, ENT_QUOTES, 'UTF-8');

    $str = str_replace('=S=temp=B=', "&lt;", $str );
    $str = str_replace('=B=temp=S=', "&gt;", $str );

    $str = preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'tt_replace_unicode_escape_sequence', $str);

    return $str;
}

function tt_replace_unicode_escape_sequence($match) {
    if (function_exists('mb_convert_encoding')){
        return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
    } else {
        return $match[0];
    }
}

function tt_add_timestamp_filter($where, $object = '')
{
    global $wpdb, $wp, $tt_timestamp_filter;

    if ( empty( $object ) )
        return $where;

    if ( $tt_timestamp_filter > 0 )
        $where .= " AND UNIX_TIMESTAMP($wpdb->posts.post_date_gmt) > $tt_timestamp_filter ";
    return $where;
}

function tt_add_post_type_filter($where, $object = '')
{
    global $wpdb, $wp, $tt_post_types;

    if ( empty( $object ) )
        return $where;

    if ( !empty($tt_post_types)){
        $post_types = "'".implode("','", $tt_post_types)."'";
        if (preg_match("/$wpdb->posts.post_type\s*?=\s*?['\"]post['\"]/", $where)){
            $where = preg_replace("/$wpdb->posts.post_type\s*?=\s*?['\"]post['\"]/", "$wpdb->posts.post_type in ($post_types)", $where);
        } else {
            $where .= " AND $wpdb->posts.post_type in ($post_types)";
        }
    }
    return $where;
}

function tt_get_post_count($cat = '', $timestemp = 0)
{
    global $wpdb;

    if ($cat || $timestemp)
    {
        $user = wp_get_current_user();

        if ($cat)
        {
            $term = get_term($cat, 'category');
            $query = "SELECT post_status, COUNT( * ) AS num_posts
                      FROM $wpdb->term_relationships INNER JOIN $wpdb->posts ON object_id = ID
                      WHERE term_taxonomy_id = '{$term->term_taxonomy_id}'";

            if ($timestemp)
            {
                $query .= " AND UNIX_TIMESTAMP(post_date_gmt) > $timestemp";
            }
        }
        else
        {
            $query = "SELECT post_status, COUNT( * ) AS num_posts FROM {$wpdb->posts} WHERE UNIX_TIMESTAMP(post_date_gmt) > $timestemp";
        }

        if ( is_user_logged_in() ) {
            $post_type_object = get_post_type_object('post');
            if ( !current_user_can( $post_type_object->cap->read_private_posts ) ) {
                $query .= " AND (post_status != 'private' OR ( post_author = '$user->ID' AND post_status = 'private' ))";
            }
        }

        $query .= ' GROUP BY post_status';
        $count = $wpdb->get_results( $query, ARRAY_A );
        $stats = array();
        foreach ( get_post_stati() as $state )
            $stats[$state] = 0;

        foreach ( (array) $count as $row )
            $stats[$row['post_status']] = $row['num_posts'];

        $numposts = (object) $stats;
    }
    else
    {
        $numposts = wp_count_posts('post', 'readable');
    }

    $total = $numposts->publish;
    if (is_user_logged_in())
        $total += $numposts->private;

    return $total;
}

function tt_json_encode($data)
{
    if (!function_exists('json_encode') || version_compare(PHP_VERSION, '5.4.0', '<'))
    {
        return tt_my_json_encode($data);
    }
    else
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}

function tt_my_json_encode($a=false)
{
    if (is_null($a)) return 'null';
    if ($a === false) return 'false';
    if ($a === true) return 'true';

    if (is_scalar($a))
    {
        if (is_float($a))
        {
            // Always use "." for floats.
            return floatval(str_replace(",", ".", strval($a)));
        }

        if (is_string($a))
        {
            static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
            return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
        }
        else
        return $a;
    }

    $isList = true;
    for ($i = 0, reset($a); $i < count($a); $i++, next($a))
    {
        if (key($a) !== $i)
        {
            $isList = false;
            break;
        }
    }

    $result = array();
    if ($isList)
    {
        foreach ($a as $v) $result[] = tt_my_json_encode($v);
            return '[' . join(',', $result) . ']';
    }
    else
    {
        foreach ($a as $k => $v) $result[] = tt_my_json_encode($k).':'.tt_my_json_encode($v);
            return '{' . join(',', $result) . '}';
    }
}