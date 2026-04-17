# SmileCare Dental — Docker Shortcuts
# Usage: make <command>

.PHONY: up down build fresh install migrate seed shell logs

## Start all containers
up:
	docker compose up -d

## Stop all containers
down:
	docker compose down

## Rebuild images
build:
	docker compose build --no-cache

## First-time setup: build, install, migrate, seed
install:
	docker compose up -d --build
	docker compose exec app composer install
	docker compose exec app cp .env.example .env
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan storage:link
	docker compose exec app npm install
	docker compose exec app npm run build

## Run migrations
migrate:
	docker compose exec app php artisan migrate

## Run seeders
seed:
	docker compose exec app php artisan db:seed

## Fresh migration + seed (wipes DB!)
fresh:
	docker compose exec app php artisan migrate:fresh --seed

## Shell into app container
shell:
	docker compose exec app bash

## Tail all logs
logs:
	docker compose logs -f

## Build frontend assets (dev with HMR)
dev:
	docker compose exec app npm run dev

## Build frontend for production
build-assets:
	docker compose exec app npm run build

## Clear all Laravel caches
clear:
	docker compose exec app php artisan optimize:clear

## Run artisan tinker
tinker:
	docker compose exec app php artisan tinker
