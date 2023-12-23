FROM php:8.3.0-apache

# php.iniの設定を変更する
ADD php.ini /usr/local/etc/php/
ADD 000-default.conf /etc/apache2/sites-enabled/

# composerをインストールする
COPY --from=composer:2.6.6 /usr/bin/composer /usr/bin/composer

# カスタムの設定、ファイル、モジュールを追加する
# モジュールをインストールする libzip-devはzipの拡張モジュール docker-php-ext-installはphpの拡張モジュールをインストールするためのコマンド
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
  && apt-get clean \
  && docker-php-ext-install zip pdo_mysql mysqli 

# Node.jsのバージョン16.xのリポジトリを追加
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash -

# Node.jsをインストール
RUN apt-get install -y nodejs
# npmをインストール
RUN apt-get install -y npm
RUN apt-get install vim -y

# ユーザーを作成する
RUN useradd -m -u 1000 -g www-data laravel

# apacheのrewriteモジュールを有効にする
RUN a2enmod rewrite

# ポートを開放する 
EXPOSE 5173
