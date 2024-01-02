### dockerのイメージ作成
```
# docker-compose.ymlファイルに定義されているサービスのイメージをビルド
$ docker-compose build

# キャッシュを無効にしてビルド
$ docker-compose build --no-cache
```

### コンテナの起動・実行
```
# -d オプションにより、コンテナはバックグラウンドで実行される
$ docker-compose up -d

# 既存のコンテナを削除して、新たにコンテナを作成して起動
$ docker-compose up -d --force-recreate

# 実行中のコマンドに入るコマンド
$ docker exec -it 【コンテナ名】 /bin/bash
```

### laravel関連コマンド
```
# もしlaravelアプリがなければ、webコンテナ内にてlaravelの新しいプロジェクトを作成。
$ composer create-project --prefer-dist "laravel/laravel=10.*" .

# composer.lock を元に各種ライブラリをインストール
$ composer install

# laravelのアプリケーションキーを作成
$ php artisan key:generate

# 公開ディレクトリとストレージディレクトリ間でシンボリックリンクを作成、アクセス権限変更。
$ php artisan storage:link
$ chmod -R 777 storage bootstrap/cache

# アプリケーションの設定内容のキャッシュをクリア。設定の変更が反映されなければまずこのコマンドを打ってみる
$ php artisan config:clear
```
<br>

ここで`http://localhost`にアクセスしてlaravelの初期ページが表示されるか確認

### DBへの接続
* .envファイルの編集
```
# DB_HOSTにはmysqlのコンテナ名を指定
# 環境変数に従ってDB接続情報を指定

DB_CONNECTION=mysql
DB_HOST=【mysqlのコンテナ名】
DB_PORT=3306
DB_DATABASE=【DB名】
DB_USERNAME=【ユーザー名】
DB_PASSWORD=【DBパスワード】
```
* DBへの接続を確認
```
# アプリの設定内容のキャッシュをクリア。新しい設定が正しく反映させるため
$ php artisan config:clear

# データベースのマイグレーションとシーディングを実行。エラーがでなければDB接続成功。
$ php artisan migrate:fresh --seed
```

### テスト用DBの作成・実行
* mysqlコンテナ内でテスト用DB作成
```
# コンテナ内でMYSQLにrootユーザーでアクセス(パスワード入力あり)
$ mysql -uroot -p

# 任意のDBを作成
$ create database test_db;

# ユーザー名に対して作成したDBへの権限を付与
$ grant all on test_db.* to 【ユーザー名】;
```
* webコンテナ内で接続設定
```
# テスト用に設定ファイルをコピー、テスト用アプリケーションキーを作成
$ cp .env.example .env.testing
$ php artisan key:generate --env=testing
```
```
# .env.testingを編集
APP_ENV=testing

DB_CONNECTION=mysql
DB_HOST=【mysqlのコンテナ名】
DB_PORT=3306
DB_DATABASE=【テストDB名】
DB_USERNAME=【ユーザー名】
DB_PASSWORD=【DBパスワード】
```
* src/phpunit.xmlを編集
```
<php>
    <server name="APP_ENV" value="testing"/> <!-- .env.testingのAPP_ENVの値をvalueに -->
    <env name="BCRYPT_ROUNDS" value="4"/>
    <env name="CACHE_DRIVER" value="array"/>
    <!-- <env name="DB_CONNECTION" value="sqlite"/> -->
    <server name="DB_CONNECTION" value="mysql_testing" /> <!-- タグ名とvalueを変更 -->
    <!-- <env name="DB_DATABASE" value=":memory:"/> -->
    <env name="MAIL_MAILER" value="array"/>
    <env name="PULSE_ENABLED" value="false"/>
    <env name="QUEUE_CONNECTION" value="sync"/>
    <env name="SESSION_DRIVER" value="array"/>
    <env name="TELESCOPE_ENABLED" value="false"/>
</php>
```
* src/config/database.phpを編集。<br>
'mysql'の設定をそのまま下にコピーして部分的に編集。
```
'mysql_testing' => [ //ここを変更
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '3306'),
    'database' => 'test_db', //ここを変更
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
```

* 接続を確認
```
# マイグレーションを実行しエラーが出なければ成功
$ php artisan migrate --database=mysql_testing
```

