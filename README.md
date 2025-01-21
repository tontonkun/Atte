# アプリケーション名
Attendance Management

![image](https://github.com/user-attachments/assets/58f8d71b-ddc7-4ddd-b8ed-f224aaf8fe1e)

# 作成目的
某企業の勤怠情報の管理

## URL
お問い合わせフォーム：http://localhost/
お問い合わせフォームの確認画面：http://localhost/confirm
サンクスページ：http://localhost/contacts
登録ページ：http://localhost/register
ログインページ：http://localhost/login
管理画面：http://localhost/admin

## 機能一覧

## 使用技術
Laravel 8.x
Github
Docker
MySQL
HTML,CSS
PHP
ER図

## テーブル設計

![image](https://github.com/user-attachments/assets/962268a8-6047-4743-b3fd-c8a617397189)


# 環境構築
docker-compose exec php bash
composer install
.env.exampleより.env作成。環境変数も変更
php artisan key:generate
php artisan migrate
php artisan db:seed

