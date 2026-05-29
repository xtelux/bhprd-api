# PDRD Integrasi Data - API

### Instalisasi
- Laravel. composer create-project "laravel/laravel:^10.0" pdrd-api
- composer require tymon/jwt-auth
- php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
- Generate secret key. php artisan jwt:secret
- Konfigurasi Auth. config/auth.php
```bash
'defaults' => [
    'guard' => 'api',
    'passwords' => 'users',
],

'guards' => [
    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],
```

### controller
- php artisan make:controller Api/AuthController
- php artisan make:controller Api/RekonPajakController
