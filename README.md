# アプリケーション名
Attendance Management

![image](https://github.com/user-attachments/assets/58f8d71b-ddc7-4ddd-b8ed-f224aaf8fe1e)

# 作成目的
某企業の勤怠情報の管理

## URL
勤怠入力フォーム：http://localhost/

勤怠一覧：http://localhost/confirm](http://localhost/time_record)

ユーザー一覧：http://localhost/contacts](http://localhost/user_list)

会員登録ページ：http://localhost/register](http://localhost/register)

ログインページ：http://localhost/login](http://localhost/login)

## 機能一覧

・会員登録

・ログイン

・勤怠入力（勤務開始/勤務終了/休暇開始/休憩終了）

・勤怠一覧

・ユーザー一覧

・ログアウト


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

## 以下のツールをインストールしてください：

・Docker: Docker公式サイトからインストール

・Docker Compose: Dockerに含まれているはずですが、必要に応じてインストール方法を確認

・Git: Git公式サイトからインストール

## インストール手順

１，リポジトリのクローン（Guthub）

```
git clone　https://github.com/your-username/your-repository.git](https://github.com/tontonkun/Atte.git)

cd your-repository
```

２，コンテナ立ち上げ（Docker Compose）

`docker-compose up -d`

３，環境設定ファイルのコピー

`cp .env .env`

４，アプリケーションキー作成

`docker-compose exec app php artisan key:generate`

５，データベースのマイグレーション

```
docker-compose exec php bash

php artisan migrate
```



※MySQLの接続設定

```
DB_CONNECTION=mysql

DB_HOST=mysql

DB_PORT=3306

DB_DATABASE=laravel_db

DB_USERNAME=laravel_user

DB_PASSWORD=laravel_pass
```




