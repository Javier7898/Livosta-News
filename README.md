
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

DB_CONNECTION=pgsql <br>
DB_HOST=127.0.0.1   <br>
DB_PORT=5432  <br>
DB_DATABASE="masukan punya anda" <br>
DB_USERNAME=postgres <br>
DB_PASSWORD="pasword anda" <br>

MAIL_MAILER=smtp <br>
MAIL_HOST=smtp.gmail.com <br>
MAIL_PORT=587 <br>
MAIL_USERNAME="gunakan email anda" <br>
MAIL_PASSWORD="password email anda" <br>
MAIL_ENCRYPTION= "tls" <br>
MAIL_FROM_ADDRESS="gunakan email anda" <br>
MAIL_FROM_NAME="${APP_NAME}" <br>

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

## Contributors 
alfianindra : Alfian Indrajaya (535220136)
Javier7898 : Javier Gustvin (535220140)
Zods3 : Arethusa Rayhan Subrata (535220164)
