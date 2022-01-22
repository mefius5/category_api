## Instrukcja do uruchomienia aplikacji

## 1. Sklonowanie repozytorium

## 2. Stworzenie bazy na localu i konfiguracja .env

## 3. 
```php
    php artisan serve
```

## 4. Puszczenie migracji (nie usuwałem wbudowanych migracji Laravela)
```php
    php artisan migrate
```
## 5. Puszczenie seedów, w tym seed z testowym userem, dla notyfikacji.
```php
    php artisan db:seed
```

## 6. Ustawienia .env dla poczty np mailtrapa, w celu sprawdzenia notyfikacji
```php
    MAIL_MAILER=
    MAIL_HOST=
    MAIL_PORT=
    MAIL_USERNAME=
    MAIL_PASSWORD=
    MAIL_ENCRYPTION=
    MAIL_FROM_ADDRESS=
```

## 7. Stworzenie bazy testowej, env.testing, odpalenie testów
```php
    php artisan test --filter CategoryTest --env=testing
```


