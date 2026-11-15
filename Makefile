PORT ?= 8080

.PHONY: help setup dev check-config key migrate cache-clear

help:
	@printf '%s\n' \
	  'make setup       Install PHP dependencies and prepare the local environment' \
	  'make dev         Run the Laravel development server on 127.0.0.1:$(PORT)' \
	  'make check-config Validate production admin credentials' \
	  'make migrate     Apply database migrations' \
	  'make key         Generate an application encryption key'

setup:
	composer install
	@test -f .env || cp .env.example .env
	@grep -q '^APP_KEY=base64:' .env || php artisan key:generate
	php artisan migrate

dev:
	APP_ENV=local SESSION_SECURE_COOKIE=false php artisan serve --host=127.0.0.1 --port=$(PORT)

check-config:
	@test -n "$$ADMIN_USERNAME" || (echo 'Set ADMIN_USERNAME first' >&2; exit 1)
	@test "$${#ADMIN_USERNAME}" -ge 4 || (echo 'ADMIN_USERNAME must be at least 4 characters' >&2; exit 1)
	@test -n "$$ADMIN_PASSWORD" || (echo 'Set ADMIN_PASSWORD first (minimum 14 characters)' >&2; exit 1)
	@test "$${#ADMIN_PASSWORD}" -ge 14 || (echo 'ADMIN_PASSWORD must be at least 14 characters' >&2; exit 1)

migrate:
	php artisan migrate

key:
	php artisan key:generate

cache-clear:
	php artisan optimize:clear
