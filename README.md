## Requirement

-   PHP 8.1 (beberapa packages requires php >= 8.2)
-   MYSQL
-   NodeJS

## Cara Install & Run Aplikasi

```sh
## Install dependencies
$ composer install
$ npm install

## Build assets
$ npm run build

## Start development server
### Menjalankan dengan berbarengan: "vite" dan "php artisan serve"
$ npm run dev
### Menjalankan dengan satu-satu
$ npm run dev:vite
$ npm run dev:artisan || php artisan serve
```


## Run Laragon (server)

```sh
$ php -S localhost:7000 -t smartaspoo-backend/public
$ grok http localhost:7000
```

