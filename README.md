# skripsianyukk

Ini file **skripsi**.

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

> Catatan:
>
> NPM cuma untuk build viewnya doang, soalnya pakai vue. Server tetep pakai php artisan

## Run Laragon (server)

```sh
$ php -S localhost:7000 -t smartaspoo-backend/public
$ grok http localhost:7000
```

## PAYMENT

No. Kartu: `4811 1111 1111 1114` <br>
CVV: `123`

## Github Actions

Kalau bisa jangan langsung push code ke `master` branch, biar quota 2,000 Actions minutes/month tidak habis.
