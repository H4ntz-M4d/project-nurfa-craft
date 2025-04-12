FROM dunglas/frankenphp:latest

# Argument untuk UID/GID agar sesuai dengan user host
ARG UID=1000
ARG GID=1000

# Buat user & group dengan UID/GID yang sesuai
RUN groupadd -g ${GID} appgroup && \
    useradd -m -u ${UID} -g ${GID} -s /bin/bash appuser

# Install ekstensi tambahan jika diperlukan
RUN install-php-extensions \
    pdo_mysql \
    gd \
    intl \
    zip \
    opcache \
    xml \
    dom \
    pcntl

# Install unzip, git, nodejs, npm
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    nodejs \
    npm

# Install Chokidar (agar bisa pakai --watch di Laravel Octane)
RUN npm install -g chokidar-cli

# Set direktori kerja dalam container
WORKDIR /app

# Copy semua file Laravel ke dalam container
COPY . /app

# Install Composer (opsional jika tidak ada di FrankenPHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependensi Laravel
RUN composer install

# Pindah kepemilikan semua file agar bisa diakses oleh appuser
RUN chown -R appuser:appgroup /app

# Pindah ke user yang dibuat
USER appuser

EXPOSE 8000

# Default command
CMD ["php", "artisan", "octane:start", "--watch"]
