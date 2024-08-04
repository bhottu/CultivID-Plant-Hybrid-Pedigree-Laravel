Google Cloud Console:

- Buka Google Cloud Console.
- Di menu sebelah kiri, navigasi ke APIs & Services > Credentials.
- Pilih OAuth 2.0 Client ID yang sudah ada atau buat yang baru.
- Di bagian Authorized redirect URIs, tambahkan:
http://your-website.com/auth/google/callback
- Simpan perubahan.

Konfigurasi file .env:

- Buka file .env proyek Laravel Anda dan tambahkan atau perbarui baris berikut:

#GOOGLE_CLIENT_ID=222782612757-vifinksb84tjpahut349lknsh3omjk5u.apps.googleusercontent.com
#GOOGLE_CLIENT_SECRET=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
#GOOGLE_REDIRECT=https://mastiff-ready-impala.ngrok-free.app/auth/google/callback

https://mastiff-ready-impala.ngrok-free.app/
ngrok http --domain=mastiff-ready-impala.ngrok-free.app 8000

Client ID
222782612757-vifinksb84tjpahut349lknsh3omjk5u.apps.googleusercontent.com
Client secret
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