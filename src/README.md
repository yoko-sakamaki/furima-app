# furima-app

coachtechフリマアプリです。

## 開発環境

- 商品一覧（トップ）: http://localhost/
- ログイン: http://localhost/login
- 会員登録: http://localhost/register
- phpMyAdmin: http://localhost:8080/

## 使用技術（実行環境）

- PHP 8.1
- Laravel 8.x
- MySQL 8.0.26
- nginx 1.21.1

## 環境構築

```bash
# 1. リポジトリをクローン
git clone git@github.com:yoko-sakamaki/furima-app.git

# 2. プロジェクトに移動
cd furima-app

# 3. コンテナ起動
docker-compose up -d --build

# 4. コンテナ内に入る
docker-compose exec php bash
```

## Laravel環境構築 コンテナ内操作

```bash
# 1. ライブラリのインストール
composer install

# 2. 環境設定ファイルの作成
cp .env.example .env

# 3. アプリケーションキーの生成
php artisan key:generate

# 4. ストレージのシンボリックリンク作成（商品画像・プロフィール画像用）
php artisan storage:link

# 5. データベースのマイグレーション及びシーディング
php artisan migrate:fresh --seed
```

## 動作確認用ログイン情報

- メールアドレス: test@example.com
- パスワード: password123

## ER図

![ER図](./src/database/er_diagram.png)
