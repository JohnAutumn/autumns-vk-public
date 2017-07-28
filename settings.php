<h1>Настройка плагина <?=VKP_PLUGIN_NAME;?></h1>
<?/*
if(isset($_POST[VKP_USER_ID_OPTION]) && isset($_POST[VKP_CLIENT_ID_OPTION])){
    update_option(VKP_USER_ID_OPTION, $_POST[VKP_USER_ID_OPTION]);
    update_option(VKP_CLIENT_ID_OPTION, $_POST[VKP_CLIENT_ID_OPTION]);
    update_option(VKP_USER_CHECK, $_POST[VKP_USER_CHECK]);
    echo "<div class='updated'>Настройки пользователя успешно сохранены</div>";
}
if(isset($_POST[VKP_GROUP_ID]) && isset($_POST[VKP_GROUP_TOKEN])){
    update_option(VKP_GROUP_ID, $_POST[VKP_GROUP_ID]);
    update_option(VKP_GROUP_TOKEN, $_POST[VKP_GROUP_TOKEN]);
    echo "<div class='updated'>Настройки группы успешно сохранены</div>";
}*/
$array_args=array(
    VKP_USER_ID_OPTION,
    VKP_CLIENT_ID_OPTION,
    VKP_ACCESS_TOKEN_OPTION,
    VKP_GROUP_ID,
    VKP_GROUP_TOKEN,
    VKP_USER_CHECK,
    VKP_USER_ALERT,
    VKP_GROUP_CHECK,
    VKP_GROUP_ALERT,
    VKP_PHOTO_ADD,
    VKP_USER_ALBUM,
    VKP_GROUP_ALBUM,
    VKP_POLL,
    VKP_POLL_TITLE,
    VKP_POLL_VARIANTS,
    VKP_POLL_ANON
);
if($_POST){
    foreach($_POST as $key=>$val){
        if(in_array($key, $array_args) && strlen($val)>0){
            update_option($key, $val);
        }
    }
    echo "<div class='updated'>Настройки пользователя успешно сохранены</div>";
}
//var_dump($_POST);
?>
<form action="" method="post">
    <h3>Основные настройки</h3>
    <table>
        <tr>
            <th>Id пользователя ВК</th>
            <td><input class="regular-text code" required="required" placeholder="Id пользователя ВК" name="<?=VKP_USER_ID_OPTION;?>" type="text" value="<?=get_option(VKP_USER_ID_OPTION);?>"/></td>
        </tr>
        <tr>
            <th>Id приложения ВК</th>
            <td><input class="regular-text code" required="required" placeholder="Id приложения ВК" name="<?=VKP_CLIENT_ID_OPTION;?>" type="text" value="<?=get_option(VKP_CLIENT_ID_OPTION);?>" /></td>
        </tr>
        <tr>
            <th>Access Token пользователя вконтакте</th>
            <td><input class="regular-text code" placeholder="Access Token вконтакте" name="<?=VKP_ACCESS_TOKEN_OPTION;?>" type="text" value="<?=get_option(VKP_ACCESS_TOKEN_OPTION);?>" /></td>
        </tr>
        <tr>
            <th>Id сообщества</th>
            <td><input class="regular-text code" placeholder="Id сообщества" name="<?=VKP_GROUP_ID;?>" type="text" value="<?=get_option(VKP_GROUP_ID);?>" /></td>
        </tr>
        <tr>
            <th>Access Token сообщества вконтакте</th>
            <td><input class="regular-text code" placeholder="Access Token сообщества вконтакте" name="<?=VKP_GROUP_TOKEN;?>" type="text" value="<?=get_option(VKP_GROUP_TOKEN);?>" /></td>
        </tr>
    </table>
    <hr>
    <h3>Настройки кнопок</h3>
    <p>Включить кнопку "Поделиться на своей страничке" <br/><input value="yes" type="radio" name="<?=VKP_USER_CHECK;?>" <? if(get_option(VKP_USER_CHECK)=="yes"){echo "checked=\"checked\"";}?> />Да <input value="no" type="radio" name="<?=VKP_USER_CHECK;?>" <? if(get_option(VKP_USER_CHECK)!="yes"){echo "checked=\"checked\"";}?> />Нет</p>
    <p>Включить кнопку "Поделиться на странице сообщества" <br/><input value="yes" type="radio" name="<?=VKP_GROUP_CHECK;?>" <? if(get_option(VKP_GROUP_CHECK)=="yes"){echo "checked=\"checked\"";}?> />Да <input value="no" type="radio" name="<?=VKP_GROUP_CHECK;?>" <? if(get_option(VKP_GROUP_CHECK)!="yes"){echo "checked=\"checked\"";}?> />Нет</p>
    <hr>
    <h3>Настройки отправки поста</h3>
    <p>Делиться записью на своей страничке, при создании/обновлении публикации <br/><input value="yes" type="radio" name="<?=VKP_USER_ALERT;?>" <? if(get_option(VKP_USER_ALERT)=="yes"){echo "checked=\"checked\"";}?> />Да <input value="no" type="radio" name="<?=VKP_USER_ALERT;?>" <? if(get_option(VKP_USER_ALERT)!="yes"){echo "checked=\"checked\"";}?> />Нет</p>
    <p>Делиться записью на странице сообщества, при создании/обновлении публикации <br/><input value="yes" type="radio" name="<?=VKP_GROUP_ALERT;?>" <? if(get_option(VKP_GROUP_ALERT)=="yes"){echo "checked=\"checked\"";}?> />Да <input value="no" type="radio" name="<?=VKP_GROUP_ALERT;?>" <? if(get_option(VKP_GROUP_ALERT)!="yes"){echo "checked=\"checked\"";}?> />Нет</p>
    <hr>
    <h3>Настройки фотографий</h3>
    <p>Добавлять фотографию поста к записи? <br/><input value="yes" type="radio" name="<?=VKP_PHOTO_ADD;?>" <? if(get_option(VKP_PHOTO_ADD)=="yes"){echo "checked=\"checked\"";}?>/>Да <input value="no" type="radio" name="<?=VKP_PHOTO_ADD;?>" <? if(get_option(VKP_PHOTO_ADD)=="no"){echo "checked=\"checked\"";}?>/>Нет</p>
    <p>Id альбома пользователя <input class="regular-text code" type="text" name="<?=VKP_USER_ALBUM;?>" value="<?=get_option(VKP_USER_ALBUM);?>" /></p>
    <p>Id альбома группы <input class="regular-text code" type="text" name="<?=VKP_GROUP_ALBUM;?>" value="<?=get_option(VKP_GROUP_ALBUM);?>" /></p>
    <hr>
    <h3>Настройки опросов</h3>
    <p>Создавать опрос, который будет прикреплён к записи (только для сообществ) <br/><input value="yes" type="radio" name="<?=VKP_POLL;?>" <? if(get_option(VKP_POLL)=="yes"){echo "checked=\"checked\"";}?> />Да <input value="no" type="radio" name="<?=VKP_POLL;?>" <? if(get_option(VKP_POLL)!="yes"){echo "checked=\"checked\"";}?> />Нет</p>
    <p>Название опроса <input class="regular-text code" type="text" name="<?=VKP_POLL_TITLE;?>" value="<?=get_option(VKP_POLL_TITLE);?>"/></p>
    <p>Анонимный опрос?<br><input value="1" type="radio" name="<?=VKP_POLL_ANON;?>" <? if(get_option(VKP_POLL_ANON)==1){echo "checked=\"checked\"";}?> />Да <input value="0" type="radio" name="<?=VKP_POLL_ANON;?>" <? if(get_option(VKP_POLL_ANON)==0){echo "checked=\"checked\"";}?> />Нет</p>
    <p>Варианты ответа (не более 10 вариантов)<br/><textarea name="<?=VKP_POLL_VARIANTS;?>" class="code" style="width: 30%;" placeholder="1-й вариант, 2-й вариант, 3-й вариант"><?=get_option(VKP_POLL_VARIANTS);?></textarea></p>
    <button type="submit" class="button-primary">Сохранить изменения</button>
</form>
<?
$get_access_token_url = "https://oauth.vk.com/authorize?" . http_build_query(array(
        'client_id' => get_option(VKP_CLIENT_ID_OPTION),
        'scope' => implode(",", array("wall", "offline", "photos", "docs")),
        'redirect_uri' => 'https://oauth.vk.com/blank.html',
        'response_type' => 'token'
    ));
if(!get_option(VKP_ACCESS_TOKEN_OPTION) && get_option(VKP_USER_ID_OPTION) && get_option(VKP_CLIENT_ID_OPTION)) {
    ?>
    <p><a href="<?= $get_access_token_url; ?>" target="_blank">Получить ключ доступа пользователя можно здесь</a></p>
    <?
}else{
    ?>
    <p><a href="<?= $get_access_token_url; ?>" target="_blank">Переиздать ключ доступа пользователя можно здесь</a></p>
    <?
}
?>
<?
$posting_uri="https://api.vk.com/method/wall.post?".http_build_query(array(
        'owner_id' => get_option(VKP_USER_ID_OPTION),
        'message' => 'Проверочная запись',
        'access_token' => get_option(VKP_ACCESS_TOKEN_OPTION),
        'response_type' => 'code'
    ));
?>
<p><a href="<?=$posting_uri;?>" target="_blank">Проверочная запись на стену пользователя</a></p>