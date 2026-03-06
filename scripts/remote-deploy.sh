#!/usr/bin/env bash
set -euo pipefail

# remote-deploy.sh
# This script is run on the target VM. It expects these environment variables to be set
# (the workflow sets them in the ssh command). It accepts either REGISTRY/REGISTRY_USERNAME/
# REGISTRY_PASSWORD or DOCKERHUB_REGISTRY/DOCKERHUB_USERNAME/DOCKERHUB_PASSWORD.
# Expected vars:
#   DOCKERHUB_REGISTRY or REGISTRY
#   DOCKERHUB_USERNAME or REGISTRY_USERNAME
#   DOCKERHUB_PASSWORD or REGISTRY_PASSWORD
#   IMAGE_NAME, IMAGE_TAG
#   ENVIRONMENT (test or production)

# Resolve registry env var fallbacks
REGISTRY_RESOLVED="${REGISTRY:-${DOCKERHUB_REGISTRY:-}}"
REGISTRY_USERNAME_RESOLVED="${REGISTRY_USERNAME:-${DOCKERHUB_USERNAME:-}}"
REGISTRY_PASSWORD_RESOLVED="${REGISTRY_PASSWORD:-${DOCKERHUB_PASSWORD:-}}"

echo "[remote-deploy] starting — env=${ENVIRONMENT:-undefined} image=${REGISTRY_RESOLVED}/${IMAGE_NAME}:${IMAGE_TAG}"

# Choose compose binary
if command -v docker-compose >/dev/null 2>&1; then
  COMPOSE_BIN="docker-compose"
elif docker compose version >/dev/null 2>&1; then
  COMPOSE_BIN="docker compose"
else
  echo "ERROR: docker-compose or 'docker compose' not found on this host"
  exit 2
fi

# Optionally login to private registry (support resolved vars)
if [ -n "${REGISTRY_USERNAME_RESOLVED:-}" ] && [ -n "${REGISTRY_PASSWORD_RESOLVED:-}" ] && [ -n "${REGISTRY_RESOLVED:-}" ]; then
  echo "[remote-deploy] logging into registry ${REGISTRY_RESOLVED}"
  echo "${REGISTRY_PASSWORD_RESOLVED}" | docker login ${REGISTRY_RESOLVED} -u "${REGISTRY_USERNAME_RESOLVED}" --password-stdin
fi

# Determine files
BASE_COMPOSE="docker-compose.yml"
ENV_COMPOSE="docker-compose.${ENVIRONMENT}.yml"

if [ -f "${ENV_COMPOSE}" ]; then
  echo "[remote-deploy] found environment compose override: ${ENV_COMPOSE}"
  echo "[remote-deploy] pulling images (may skip if image tags are already present)"
  ${COMPOSE_BIN} -f ${BASE_COMPOSE} -f ${ENV_COMPOSE} pull || echo "pull returned non-zero; continuing"
  echo "[remote-deploy] bringing up stack (with override)"
  ${COMPOSE_BIN} -f ${BASE_COMPOSE} -f ${ENV_COMPOSE} up -d --remove-orphans --build
else
  echo "[remote-deploy] no env-specific compose file found; using ${BASE_COMPOSE}"
  ${COMPOSE_BIN} pull || echo "pull returned non-zero; continuing"
  ${COMPOSE_BIN} up -d --remove-orphans --build
fi

echo "[remote-deploy] rotate images/cleanup"
docker image prune -f || true

echo "[remote-deploy] deployment finished"
