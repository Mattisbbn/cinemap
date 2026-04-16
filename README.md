# Projet Laravel

Application web construite avec Laravel 13.

## Prerequis

- PHP 8.3 minimum
- Composer
- Node.js et pnpm

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
pnpm install
```

## Lancer le projet

Utilise la commande suivante pour lancer le serveur Laravel, les logs, la queue et Vite en meme temps:

```bash
composer run dev
```

## Qualite de code

Pour verifier et formatter le code PHP avec Laravel Pint:

```bash
./vendor/bin/pint
```