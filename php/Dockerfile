FROM php:8.2-rc-apache
# ① 「user」という名の一般ユーザーを作成。
ARG USERNAME=user
ARG GROUPNAME=user
ARG UID=1000
ARG GID=1000
RUN groupadd -g $GID $GROUPNAME && \
    useradd -m -s /bin/bash -u $UID -g $GID $USERNAME
# ②「libzip-dev」「unzip」「pdo_mysql」「zip」「xdebug」「mhsendmail」をインストール＆有効化
RUN apt-get update \
  && apt-get install -y --no-install-recommends libzip-dev unzip \
  && docker-php-ext-install pdo_mysql zip \
  && pecl install xdebug \
  && docker-php-ext-enable xdebug \
  && curl -sSL https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 -o mhsendmail \
  && chmod +x mhsendmail \
  && mv mhsendmail /usr/local/bin/mhsendmail
# ③ ComposerをPHPコンテナ内に取り入れる
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer
# ④ 自作の設定ファイル「myphp.ini」「docker-php-ext-xdebug.ini」をPHPコンテナに適用させる
COPY myphp.ini /usr/local/etc/php/conf.d
COPY docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
# ⑤ PHPコンテナ内に入った時のカレントディレクトリを指定
WORKDIR /var/www/html
EXPOSE 80

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf