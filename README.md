# Проект Laravel: Конфигурация и Загрузка Городов

## Шаги по установке проекта

### 1. Клонирование репозитория
Клонируйте проект из репозитория:
```bash
git clone <ссылка-на-репозиторий>
cd <название-проекта>
```

### 2.Установка зависимостей
Установите все необходимые зависимости с помощью Composer:
```bash
composer install
```

### 3.Настройка файла конфигурации
Скопируйте файл .env.example и переименуйте его в .env:
```bash
cp .env.example .env
```

### 4.Генерация ключа приложения
Сгенерируйте новый ключ для приложения:
```bash
php artisan key:generate
```

### 5. Настройка параметров базы данных
Отредактируйте файл .env, указав параметры подключения к вашей базе данных:
```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=<название_базы_данных>
DB_USERNAME=<имя_пользователя>
DB_PASSWORD=<пароль>
```

### 6. Запуск миграций
Запустите миграции для создания необходимых таблиц в базе данных:
```bash
php artisan migrate
```

### 7. Настройка прав на директории
Убедитесь, что директории storage и bootstrap/cache имеют правильные права доступа:
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```
### 8. Команда для получения данных о городах
После настройки проекта выполните следующую команду для загрузки данных о городах с API:
```bash
php artisan app:parse-cities
```

### 9. Запуск локального сервера
Запустите сервер разработки Laravel:
```bash
php artisan serve
```

# Команды cURL для работы с городами
### Получение списка городов (GET)

```bash
curl -X GET http://your-domain.com/cities
```

### Добавление нового города (POST)
```bash
curl -X POST http://your-domain.com/cities \
-H "Content-Type: application/json" \
-d '{"name": "test"}'
```

### Удаление города (DELETE)
```bash
curl -X DELETE http://your-domain.com/cities/{id}

```