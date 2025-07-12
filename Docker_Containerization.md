🐳 Docker Containerization Guide for HRM System
This document provides a detailed overview of Docker-based containerization for the HRM (Human Resource Management) system, including the service architecture, container setup, and configuration using Dockerfile and docker-compose.yaml.

📦 Containerized Services Overview
Service	Description
frontend	PHP Apache-based UI for HRM dashboard
backend	PHP CLI API service with MySQL and Redis
db	MySQL 8 database with initialization script
redis	Redis instance for caching
prometheus	Monitoring service for metrics
grafana	Dashboard service to visualize metrics
loki	Logging backend used with Promtail

🧱 Dockerfiles
1. frontend/Dockerfile
FROM php:8.1-apache
COPY . /var/www/html/
EXPOSE 80
Base Image: PHP 8.1 with Apache

Copy Source: Entire frontend source is copied into /var/www/html/

Exposed Port: 80 (default HTTP)

2. backend/Dockerfile
FROM php:8.1-cli
RUN docker-php-ext-install mysqli && pecl install redis && docker-php-ext-enable redis
COPY . /app
WORKDIR /app
CMD ["php", "-S", "0.0.0.0:8080"]
EXPOSE 8080
Base Image: PHP 8.1 CLI

Extensions: Installs mysqli and redis extensions

Code Location: /app

Web Server: PHP's built-in server at port 8080

Exposed Port: 8080

🧩 Docker Compose Setup
docker-compose.yaml
version: '3.8'

services:
  frontend:
    build: ./frontend
    ports:
      - "8081:80"
    environment:
      - API_URL=${API_URL}
    depends_on:
      - backend

  backend:
    build: ./backend
    ports:
      - "8080:80"
    environment:
      - DB_HOST=${DB_HOST}
      - DB_USER=${DB_USER}
      - DB_PASSWORD=${DB_PASSWORD}
      - DB_NAME=${DB_NAME}
      - REDIS_HOST=${REDIS_HOST}
    depends_on:
      - db
      - redis

  db:
    image: mysql:8
    restart: always
    environment:
      - MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD}
      - MYSQL_DATABASE=${MYSQL_DATABASE}
    volumes:
      - ./db/init.sql:/docker-entrypoint-initdb.d/init.sql
    ports:
      - "3306:3306"

  redis:
    image: redis:alpine
    ports:
      - "6379:6379"

  prometheus:
    image: prom/prometheus
    volumes:
      - ./monitoring/prometheus.yml:/etc/prometheus/prometheus.yml
    ports:
      - "9090:9090"

  grafana:
    image: grafana/grafana
    environment:
      - GF_SECURITY_ADMIN_USER=${GF_SECURITY_ADMIN_USER}
      - GF_SECURITY_ADMIN_PASSWORD=${GF_SECURITY_ADMIN_PASSWORD}
    ports:
      - "3000:3000"

  loki:
    image: grafana/loki:2.9.2
    ports:
      - "3100:3100"
🔐 Environment Variables (.env)
# Database
DB_HOST=
DB_USER=
DB_PASSWORD=
DB_NAME=
MYSQL_ROOT_PASSWORD=
MYSQL_DATABASE=

# Redis
REDIS_HOST=redis

# Backend API for Frontend
API_URL=http://backend/employees

# Grafana
GF_SECURITY_ADMIN_USER=
SECURITY_ADMIN_PASSWORD=
🚀 How to Run
Create .env file based on the above environment variables.

Build and start containers:

docker-compose up --build -d
Access Services:

Service	URL
Frontend	http://localhost:8081
Backend	http://localhost:8080
MySQL	localhost:3306
Redis	localhost:6379
Prometheus	http://localhost:9090
Grafana	http://localhost:3000
Loki	http://localhost:3100

📁 Monitoring and Logging
Prometheus scrapes metrics from configured targets.

Grafana visualizes metrics (use Prometheus as datasource).

Loki collects logs (requires Promtail to push logs).

To collect container logs using Promtail, mount Docker log paths and configure a promtail config.