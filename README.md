# tvp-lab8

### Получаем ссылку для аутентификации пользователя, разрешаем доступ к данным
$url = App::get_code_token();
echo $url;

### Из адресной строки берем значение code и передаем в метод get_token для получения access_token
$resp = App::get_token( <code> );

Из массива значение <access_token> присваем константе TOKEN в App.php