Аккаунт администратора:
admin@test.ru
12345678

Аккаунт Автора:
author@test.ru
12345678

Реализация:
У Пользователя и Автора - OneToOne.
У Автора и книги - OneToMany.
У Книг и Жанров - ManyToMany.

В качестве модуля аутентификации используется Laravel Breeze.
Для авторизации по API используется Sanctum.
Роуты API в api.php.
Методы API в тех же контроллерах, что и остальные методы. (PS: не лучшее решение)
Валидация форм в Requests.
Валидация API запросов в Requests\API.
При действиях с книгами пишется уведомление в laravel.log.#   s o m e b o o k s  
 