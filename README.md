### dockerのイメージ作成
```
# docker-compose.ymlファイルに定義されているサービスのイメージをビルド
$ docker-compose build

# キャッシュを無効にしてビルド
$ docker-compose build --no-cache
```

### コンテナの起動
```
# -d オプションにより、コンテナはバックグラウンドで実行される
$ docker-compose up -d
```