# FILE SHARE

Проект-пример работы с symfony

### Требования

- PHP версии 7.4+

### Установка

Разворачивание

```bash
composer install
php7.4 bin/console doctrine:database:create
php7.4 bin/console doctrine:migrations:migrate
```

Настройки

```env
APP_ENV=prod
APP_SECRET=заменить на секрет с высокой энтропией

FILE_LIFETIME=время жизни файлов в секундах
FILE_STORAGE=путь сохранения относительно папки public
```

Команда очистки устаревших файлов (добавляется в cron)

```
php7.4 bin/console app:clear
```

Примечания

- Так как база данных реализована через sqllite, файл базы данных должен иметь права на чтение и запись
- Путь FILE_STORAGE аналогично должен иметь доступ для чтения-записи

### API

#### Загрузка файла

Post запрос типа form-data/multipart-form-data

```
POST {{host}}/api/file
```

Поля формы

| Поле | Описание |
| --- | --- |
| file | Загружаемый файл |

Пример ответа

```json
{
    "code": "f016fol8l",
    "url": "{{host}}/f016fol8l"
}
```

#### Получение информации по коду UID

Get запрос с получением информации по файлу. Если файла нет будет выдан статус ошибки 404.

```
GET {{host}}/api/file/:code
```

Пример ответа

```json
{
    "name": "original_file_name.txt",
    "url": "{{host}}/f016fol8l",
    "timestamp": 1649397579
}
```

#### Прямое скачивание по коду

В случае нахождения файла выдает его на скачивание с соответствующими заголовками. Если файл не найден выдаст статус ошибки 404.

```
GET {{host}}/:code
```

Пример

```
https://your-file-share-domain.ru/f016fol8l
```
