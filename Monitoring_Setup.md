📊 Monitoring_Setup.md
📘 Overview
This document outlines the monitoring and logging stack implemented for the HRM application deployed in Kubernetes. It explains how Prometheus, Grafana, and Loki are deployed and integrated to collect metrics and logs from various services, and how to access and interpret dashboards and set up alerts.

✅ Stack Components
Tool	Purpose
Prometheus	Metrics collection and scraping
Grafana	Visualization and alerting
Loki	Log aggregation and querying
Promtail	Agent for shipping logs to Loki

🏗️ Deployment Architecture
All monitoring components are deployed within the hrm namespace.
+---------------------+
|   Grafana Dashboard |
+---------------------+
          |
     +----+----+
     | Metrics |
     v         v
Prometheus   Loki <--- Promtail <--- Containers (frontend, backend, etc.)

📊 Visualizing Metrics
In Grafana:

Add Prometheus as a data source (http://prometheus:9090).

Add Loki as a log source (http://loki:3100).

Import dashboards from Grafana Labs (e.g., Docker, MySQL, PHP).

📣 Setting Up Alerts
Create Alert Rules (in Prometheus):

In Grafana:

Added Prometheus as a data source (http://prometheus:9090).

Added Loki as a log source (http://loki:3100).

Imported dashboards from Grafana Labs (e.g., Docker, MySQL, PHP).