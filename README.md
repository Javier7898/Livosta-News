
## Livosta News

Livosta news adalah website yang dirancang untuk Unit kegiatan mahasiswa yang ada di universitas tarumanagara untuk mempermudah persebaran informasi 

Tata cara yang harus dilakukan untuk dapat run: 

``` bash
git clone https://github.com/Javier7898/Livosta-News.git
```

``` bash
composer install
```
# Pengaturan Database

tahap selanjutnya adalah ganti config/database.php pada pgsql dengan db yang ada di localhost anda

rubah .env pada bagian database diganti: 

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE="masukan punya anda"
DB_USERNAME=postgres
DB_PASSWORD="pasword anda"

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME="gunakan email anda"
MAIL_PASSWORD="password email anda"
MAIL_ENCRYPTION= "tls"
MAIL_FROM_ADDRESS="gunakan email anda"
MAIL_FROM_NAME="${APP_NAME}"

# nambahin gambar 
``` bash
php artisan storage:link
```

# Memasukan tabel ke database

``` bash
php artisan migrate
```

## untuk menjalankan website laravel gunakan command ini :

``` bash
php artisan serve
```
