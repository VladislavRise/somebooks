Сайт: https://somebooks.site <br>
<b>Аккаунт администратора:</b><br>
admin@test.ru<br>
12345678<br>
<br>
Аккаунт Автора:<br>
author@test.ru<br>
12345678<br>
<br>
<b>Реализация:</b><br>
У Пользователя и Автора - OneToOne.<br>
У Автора и книги - OneToMany.<br>
У Книг и Жанров - ManyToMany.<br>
<br>
В качестве модуля аутентификации используется Laravel Breeze.<br>
Для авторизации по API используется Sanctum.<br>
Роуты API в api.php.<br>
Методы API в тех же контроллерах, что и остальные методы. (PS: не лучшее решение)<br>
Валидация форм в Requests.<br>
Валидация API запросов в Requests\API.<br>
При действиях с книгами пишется уведомление в laravel.log.#   s o m e b o o k s 
 
 
