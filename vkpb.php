<?php
/*
Plugin Name: Vk public by John Autumn
Plugin URI:
Description: Производит публикацию записей блога на страничку Вконтакте
Version: 1.4
Author: John Autumn
Author URI: http://johnautumn.ru
License: GPL2
Copyright: 2017
*/
const VKP_PLUGIN_ID="autumns-vk-public";
const VKP_PLUGIN_NAME="Публикации ВК";
const VKP_USER_ID_OPTION="vkp_user_id";//ид пользователя вк
const VKP_CLIENT_ID_OPTION="vkp_client_client_id";//ид приложения вк
const VKP_ACCESS_TOKEN_OPTION="vkp_access_token";//токен приложения
const VKP_GROUP_ID="vkp_group_id";//ид группы вк
const VKP_GROUP_TOKEN="vkp_group_token";//Токен группы вк
const VKP_USER_CHECK="vkp_user_check";//Состояние кнопки "Поделиться на своей страничке"
const VKP_USER_ALERT="vkp_user_alert";//Состояние всплывающего окна "Поделиться на своей страничке"
const VKP_GROUP_CHECK="vkp_group_check";//Состояние кнопки "Поделиться в группе"
const VKP_GROUP_ALERT="vkp_group_alert";//Состояние всплывающего окна "Поделиться в группе"
const VKP_POLL="vkp_poll";//Состояние галочки "создавать опрос"
const VKP_POLL_TITLE="vkp_poll_title";//Название создаваемого опроса
const VKP_POLL_VARIANTS="vkp_poll_variants";//Варианты ответа создаваемого опроса
const VKP_POLL_ANON="vkp_poll_anon";//Анонимность опроса

include "functions.php";//подключение файла функций

add_action("admin_menu","vkp_settings_menu");//Добавляем пункт меню настроек

//$admin_page=str_replace(array("/","?","=","wp-admin"),"",$_SERVER['REQUEST_URI']);
add_action("wp_ajax_post_vk", "post_publ_vk", 10);//Публикация поста на стену

add_action("wp_ajax_post_vk_group", "post_publ_group", 10);//Публикация поста в группу

add_action("wp_ajax_post_vk_ajax", "get_ajax_pub", 10);

//Пользовательские публикации
if(get_option(VKP_USER_ALERT)=="yes"){
    add_action("admin_footer", "ask_to_public");//Опубликовать запись ВК?
}
if(get_option(VKP_USER_CHECK)=="yes"){
    add_action("post_submitbox_start", "add_user_button");//Кнопка публикации на страничку
}
//Публикации в группе
if(get_option(VKP_GROUP_ALERT)=="yes"){
    add_action("admin_footer", "ask_to_public_group");//Опубликовать запись в группу?
}
if(get_option(VKP_GROUP_CHECK)=="yes"){
    add_action("post_submitbox_start", "add_group_button");//Кнопка публикации в группу
}

if(get_option(VKP_USER_CHECK)=="yes" || get_option(VKP_GROUP_CHECK)=="yes"){
    add_action("admin_footer", "get_ajax_posting");
}

