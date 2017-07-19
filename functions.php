<?php
/**
 * Created by PhpStorm.
 * User: Бондарев
 * Date: 17.07.2017
 * Time: 16:02
 */
function vkp_settings_menu(){
    add_options_page(
        "Настройки плагина ".VKP_PLUGIN_NAME,
        VKP_PLUGIN_NAME,
        8,
        VKP_PLUGIN_ID,
        "render_vkp_settings_page"
    );
}

function render_vkp_settings_page(){
    include "settings.php";
}
//Публикация записи
function vk_wall_publisher($message, $attachments='', $for='wall', $poll=false){
    $message=str_replace("{br}", "\n\n", $message);
    $message=str_replace("\\\"", "\"", $message);
    if($for=='wall'){
        $posting_uri="https://api.vk.com/method/wall.post?".http_build_query(array(
                'owner_id' => get_option(VKP_USER_ID_OPTION),
                'message' => $message,
                'access_token' => get_option(VKP_ACCESS_TOKEN_OPTION),
                'attachments' => $attachments
            ));
    }else{
        $posting_uri="https://api.vk.com/method/wall.post?".http_build_query(array(
                'owner_id' => "-".get_option(VKP_GROUP_ID),
                'message' => $message,
                'access_token' => get_option(VKP_ACCESS_TOKEN_OPTION),
                'attachments' => $attachments,
                'signed' => 0
            ));
    }
    $result=file_get_contents($posting_uri);
    return $result;
}

function ask_to_public(){
    $id=$_GET['post'];
    $post=get_post($id);
    $content = strip_tags(stristr($post->post_content, "<!--more-->", true));
    $text=$post->post_title."{br}".$content;
    ?>
    <script>
        jQuery('form#post').on('submit',function (event) {
            if(confirm('Опубликовать запись на стене?')){
                jQuery.post(ajaxurl, {action: 'post_vk', id: '<?=$id;?>', title: '<?=$text;?>'}, function (response) {
                    console.log(response);
                    alert('Успешно опубликовано на стене ВК');
                })
            }
        });
    </script>
    <?
}

function ask_to_public_group(){
    $id=$_GET['post'];
    $post=get_post($id);
    $content = strip_tags(stristr($post->post_content, "<!--more-->", true));
    $text=$post->post_title."{br}".$content;
    ?>
    <script>
        jQuery('form#post').on('submit',function (event) {
            if(confirm('Опубликовать запись на стене в группе?')){
                jQuery.post(ajaxurl, {action: 'post_vk_group', id: '<?=$id;?>', title: '<?=$text;?>'}, function (response) {
                    console.log(response);
                    alert('Успешно опубликовано на стене группы ВК');
                })
            }
        });
    </script>
    <?
}

function post_publ_vk(){
    $title=str_replace("{br}", "\n\n", $_REQUEST['title']);
    $title=str_replace("\\\"", "\"", $title);
    $permalink=get_permalink($_REQUEST['id']);
    vk_wall_publisher($title, $permalink, "wall");
}

function post_publ_group(){
    $title=str_replace("{br}", "\n\n", $_REQUEST['title']);
    $title=str_replace("\\\"", "\"", $title);
    $permalink=get_permalink($_REQUEST['id']);
    vk_wall_publisher($title, $permalink, "post");
}

function add_user_button(){
    if($_GET['post']) echo "<p><input id=\"pub_user\" type=\"button\" value='Опубликовать на стене Вконтакте' class='button button-secondary' /></p>";
}

function add_group_button(){
    if($_GET['post']) echo "<p><input id=\"pub_group\" type=\"button\" value='Опубликовать в сообществе Вконтакте' class='button button-secondary' /></p>";
}

function get_ajax_posting(){
    $id=$_GET['post'];
    $post=get_post($id);
    $content = strip_tags(stristr($post->post_content, "<!--more-->", true));
    $text=$post->post_title."{br}".$content;
    ?>
    <script>
        jQuery('input#pub_user, input#pub_group').on('click',function (event) {
            var type="post";
            var conf="Опубликовать запись на стене в группе?";
            var suc="Запись опубликована";
            if(jQuery(this).is("#pub_user")){
                type="wall";
                conf="Опубликовать запись на Вашей стене?";
            }
            if(confirm(conf)){
                jQuery.post(ajaxurl, {action: 'post_vk_ajax', id: '<?=$id;?>', title: '<?=$text;?>', type:type},  function (response) {
                    alert(suc);
                });
            }
        });
    </script>
    <?
}
function get_ajax_pub(){
    $title=str_replace("{br}", "\n\n", $_REQUEST['title']);
    $title=str_replace("\\\"", "\"", $title);
    $permalink=get_permalink($_REQUEST['id']);
    $type=$_REQUEST['type'];
    $att=$permalink;
    if(get_option(VKP_POLL)=="yes"){
        $poll=create_poll($type);
        $poll['response']=(array) $poll['response'];
        var_dump($poll);
        $att.=",poll".$poll['response']['owner_id']."_".$poll['response']['poll_id'];
    }
    vk_wall_publisher($title,$att, $type);
}
function create_poll($type){
    $owner=get_option(VKP_USER_ID_OPTION);
    $vars=json_encode(explode(",",get_option(VKP_POLL_VARIANTS)));
    $posting_uri="https://api.vk.com/method/polls.create?".http_build_query(array(
            'owner_id' => $owner,
            'question' => get_option(VKP_POLL_TITLE),
            'is_anonymous' => get_option(VKP_POLL_ANON),
            'add_answers' => $vars,
            'access_token' => get_option(VKP_ACCESS_TOKEN_OPTION),
        ));
    $result=file_get_contents($posting_uri);
    return (array) json_decode($result);
}