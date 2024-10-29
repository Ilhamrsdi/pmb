# PMB Poliwangi

## Persyaratan

-   PHP >= 8.0.1
-   Composer Versi 2
-   VSCode

## Instalasi

1. Buka terminal dan clone projek ini dari github

```bash
git clone https://github.com/Ilhamrsdi/pmb.git
```

2. Arahkan lokasi terminal ke lokasi projek yang sudah di clone

```bash
cd pmb-poliwangi
```

3. Buka Visual Studio Code

```bash
code .
```

4. Ganti nama file .env.example menjadi .env

```bash
.env.example (sebelum)
.env (sesudah)
```

5. Nyalakan XAMPP dan buat database baru (nama database bebas)

6. Sesuaikan nama database yang telah dibuat pada file .env

```bash
DB_CONNECTION=mysql         (default)
DB_HOST=127.0.0.1           (default)
DB_PORT=3306                (default)
DB_DATABASE=pmb             (rubah sesuai dengan db yang telah dibuat)
DB_USERNAME=root            (default)
DB_PASSWORD=                (default)
```

7. Instal depedency laravel dan lainnya

```bash
composer install
```

8. Buat Key projek baru

```bash
php artisan key:generate
```

9.  Lakukan migrate database beserta data dummynya

```bash
php artisan migrate:fresh --seed
```

10. Instal depedency javascript

```bash
npm install
```

11. Jalankan server laravel

```bash
php artisan serve
```

12. Buka terminal baru, untuk compile asset Frontend

```bash
npm run watch
```

13. Buka browser localhost:8000 dan masuk sebagai admin

```bash
email: admin@gmail.com
password: admin123
```
