#!/bin/sh
# PHP 서버 시작 스크립트

# 환경 변수 설정
export PORT=${PORT:-8080}

# PHP 내장 서버 실행
php -S 0.0.0.0:$PORT
