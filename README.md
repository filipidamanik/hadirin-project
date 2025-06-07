![Tampilan Home](https://github.com/arditam/hadirin/blob/main/public/doc/home.jpg)
![Tampilan Halaman Input Anggota](https://github.com/arditam/hadirin/blob/main/public/doc/input_anggota.jpg)
![Tampilan Halaman Input Kegiatan](https://github.com/arditam/hadirin/blob/main/public/doc/input_kegiatan.jpg)
![Tampilan Halaman Generate ID](https://github.com/arditam/hadirin/blob/main/public/doc/generate_id.jpg)
![Tampilan Halaman Scan Kehadiran](https://github.com/arditam/hadirin/blob/main/public/doc/scan_kehadiran.jpg)
![Tampilan Halaman Print Kehadiran Harian](https://github.com/arditam/hadirin/blob/main/public/doc/kehadiran_harian.jpg)
![Tampilan Halaman Print Kehadiran Bulanan](https://github.com/arditam/hadirin/blob/main/public/doc/kehadiran_bulanan.jpg)
![Tampilan Halaman Print ID Anggota](https://github.com/arditam/hadirin/blob/main/public/doc/print_id_anggota.jpg)


## 🛠️ Tech Stack
- Laravel 12
- Tailwind CSS

## ⚙️ Setup Guide

### 1. Clone project
```bash
git clone https://github.com/arditam/hadirin.git
cd hadirin
```
### 2. Copy file .env.example
```bash
copy .env.example .env
```
### 3. Setup database pada komputer anda, lalu masukkan kredensial-kredensialnya ke file .env.
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_hadirin5
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Install dependency
```bash
composer install
```

### 5. Generate application key
```bash
php artisan key:generate
```
### 6. Link storage untuk file upload
```bash
php artisan storage:link
```
### 7. Migrasi database
```bash
php artisan migrate
```
### 8. Jalankan aplikasi
```bash
php artisan serve
```

### 9. Kalau eror SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_hadirin5.sessions' doesn't exist (Connection: mysql, SQL: select * from sessions where id = Suo58Euw1g688Pj7R9Eq8XMjgGaADBkQTacjtoRq limit 1)
```bash
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

```

Sc.Rifqi Ardian
