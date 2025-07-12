☸️ Kubernetes Architecture for HRM System
This document outlines the Kubernetes-based architecture used to deploy and manage the Human Resource Management (HRM) application. It includes a description of the core components, namespaces, services, and how everything is orchestrated in a production-ready Kubernetes environment.

📦 Application Overview
The HRM system is a microservices-style 3-tier application comprising:

Frontend (Apache + PHP) — UI interface

Backend (PHP CLI) — API logic with MySQL + Redis

MySQL — Relational database

Redis — In-memory cache

Grafana + Prometheus + Loki — Monitoring and logging stack

🗂️ Namespace
All application components are deployed under the custom namespace: hrm
🔧 Deployment Structure
🧩 Frontend
Image: ringkokabiraj/hrm-frontend:latest

Exposed Port: 80

Environment Variable: API_URL=http://backend/employees
🧩 Backend
Image: ringkokabiraj/hrm-backend:latest

Exposed Port: 8080

Environment Variables: DB & Redis configuration

🗄️ MySQL
Persistent Volume via PVC

Init SQL for schema and table

Secret/Env Config: MYSQL_ROOT_PASSWORD, MYSQL_DATABASE

🧠 Redis
Stateless in-memory data store

Used for caching employee data
📊 Monitoring & Logging Stack
🔍 Prometheus
Scrapes /metrics endpoints

Deployed using Docker or Helm

📈 Grafana
Connects to Prometheus and Loki

Dashboards to monitor system health

📄 Loki + Promtail
Loki collects logs from pods

Promtail is deployed as DaemonSet

Log labels (job, namespace, app) are configured

🔐 Config and Secrets
Configuration is handled using ConfigMap and Secrets.
🔁 CI/CD Pipeline Integration
The system integrates with GitHub Actions to:

Build and push Docker images

Automatically deploy new versions to the Kubernetes cluster using kubectl apply

Kubeconfig is passed via secret and base64 encoded for authentication on self-hosted runners.