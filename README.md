# Back-End Aplikasi Bookio (Aplikasi Penyewaan Studio Musik)

_bookio merupakan project akhir saya selama menempuh pendidikan di bangku perkuliahan tepatnya di Politeknik Negeri Banyuwangi Jurusan D3 Teknik Informatika. Ini merupakan file project backend dari aplikasi bookio dimana agar frontend aplikasi bookio dapat di jalankan maka harus menjalankan backend dari aplikasi bookio. Setelah anda menjalankan beckend maka anda akan dapat mengakses tampilan dashboard admin pada website dan menjalankan frontend aplikasi bookio (mobile)._

### Configurasi Back-End

-   _Download project dengan cara buka terminal ketikan :_
    `git clone git@github.com:bogaZ/back-end-bookioApp.git`
-   _Membuat database dengan nama bebas misal :_ **laravel_bookio**
-   _Membuat file_ `.env`_lalu copy semua isi dari file_ `.env.example` _ke file_ `.env`
-   _Configurasi_ `DB_DATABASE=laravel_bookio` _pada file_ `.env` _sesuai dengan nama database_
-   _Buka terminal masuk ke folder_ **back-end-bookioApp** _dan jalankan perintah :_

    `composer update`

    `php artisan migrate`

    `php artisan serve`

-   _Lalu akses aplikasi sesuai nama domain misal :_ http://localhost:8000/
-   _Halaman website akan error dikarenakan anda harus meregenerate API Keys_
-   **Generate API KEYS**
-   _Akses kembali website sesuai nama domain misal :_ http://localhost:8000/
-   _Jika berhasil anda akan diarahkan ke login admin_
-   _Login ke dashboard admin dengan menggunakan :_
-   _Username :_ **adminbookio@gmail.com**
-   _Password :_ **12345678**
