#!/usr/bin/env bash
set -euo pipefail

# remote-deploy.sh
# This script is run on the target VM. It expects these environment variables to be set
# (the workflow sets them in the ssh command):
#   REGISTRY, REGISTRY_USERNAME, REGISTRY_PASSWORD (optional if public)
#   IMAGE_NAME, IMAGE_TAG
#   ENVIRONMENT (test or production)

echo "[remote-deploy] starting — env=${ENVIRONMENT:-undefined} image=${REGISTRY}/${IMAGE_NAME}:${IMAGE_TAG}"

# Choose compose binary
if command -v docker-compose >/dev/null 2>&1; then
  COMPOSE_BIN="docker-compose"
elif docker compose version >/dev/null 2>&1; then
  COMPOSE_BIN="docker compose"
else
  echo "ERROR: docker-compose or 'docker compose' not found on this host"
  exit 2
fi

# Optionally login to private registry
if [ -n "${REGISTRY_USERNAME:-}" ] && [ -n "${REGISTRY_PASSWORD:-}" ] && [ -n "${REGISTRY:-}" ]; then
  echo "[remote-deploy] logging into registry ${REGISTRY}"
  echo "${REGISTRY_PASSWORD}" | docker login ${REGISTRY} -u "${REGISTRY_USERNAME}" --password-stdin
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
