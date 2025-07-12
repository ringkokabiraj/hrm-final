🔐 Secret_Management.md
📘 Overview
This document describes the secret management strategy used in the Kubernetes deployment of the Human Resource Management (HRM) system. It outlines how secrets are created, stored, and accessed securely within the cluster, ensuring sensitive data (like DB credentials and API keys) is not hardcoded or exposed in configuration files.

✅ Chosen Strategy
The HRM system uses Kubernetes native Secrets as the primary secret management mechanism.

Secrets are:

Base64-encoded (not encrypted at rest unless etcd encryption is enabled).

Scoped by namespace (used in hrm namespace).

Mounted as environment variables in pods for secure access.

🔐 Secrets Used
Secret Key	Description	Consumed By
DB_USER for	MySQL username	Backend
DB_PASSWORD for	MySQL password	Backend
MYSQL_ROOT_PASSWORD for	MySQL root password	MySQL container
GF_SECURITY_ADMIN_USER for Grafana admin username	Grafana
GF_SECURITY_ADMIN_PASSWORD for 	Grafana admin password	Grafana