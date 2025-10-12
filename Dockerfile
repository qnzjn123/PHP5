FROM php:8.2-cli

# 작업 디렉토리 설정
WORKDIR /app

# PHP MySQL 확장 설치
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 애플리케이션 파일 복사
COPY . /app

# 포트 노출
EXPOSE 8080

# 환경 변수 설정
ENV PORT=8080

# 애플리케이션 실행
CMD php -S 0.0.0.0:${PORT} -t .
