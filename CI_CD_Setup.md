🚀 CI/CD Setup for HRM Application
This document outlines the Continuous Integration and Continuous Deployment (CI/CD) setup for the HRM (Human Resource Management) application using GitHub Actions. The system builds Docker images for the frontend and backend, pushes them to Docker Hub, and deploys them to a self-hosted Kubernetes cluster.

🔧 Chosen CI/CD Tool: GitHub Actions
GitHub Actions is used for:

Automating Docker builds.

Authenticating and pushing to Docker Hub.

Applying Kubernetes manifests to a cluster.

Restarting deployments after each update.

🧱 Workflow Stages Breakdown
1. Trigger
When: On push to main branch.

Purpose: Automate the pipeline when code changes are pushed.

2. Build & Push Stage
Runner: GitHub-hosted ubuntu-latest

Actions Used:

actions/checkout: Checkout code.

docker/setup-buildx-action: Setup Docker Buildx.

docker/login-action: Log into Docker Hub.

docker/build-push-action: Build and push images.

Tasks:

Build frontend image from ./frontend

Build backend image from ./backend

Tag and push both images to Docker Hub using credentials in secrets.

3. Deploy Stage
Runner: self-hosted (on your Kubernetes master or CI node)

Tasks:

Decode base64 kubeconfig stored in KUBE_CONFIG secret and place it in $HOME/.kube/config.

Run kubectl apply on all manifests in k8s/ directory.

Restart deployments using kubectl rollout restart to ensure latest image is pulled and deployed.

## Monitor the Pipeline
Go to your repository on GitHub.

Click the Actions tab.

Select the CI/CD Pipeline workflow.

View live logs for each job:

     build-and-push

     implement