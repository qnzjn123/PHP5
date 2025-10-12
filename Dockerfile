FROM php:8.2-cli

# 작업 디렉토리 설정
WORKDIR /app

# 필요한 패키지 설치
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*

# 애플리케이션 파일 복사
COPY . /app

# 포트 노출
EXPOSE 8080

# 환경 변수 설정
ENV PORT=8080

# 애플리케이션 실행
CMD php -S 0.0.0.0:${PORT} -t .
