# CineMap

Application Laravel pour gerer des emplacements de tournage de films.

## Prerequis

- PHP 8.3+
- Composer
- Node.js 20+
- pnpm
- Une base SQLite ou MySQL

## 1) Installer le projet

Depuis la racine du projet:

	composer install
	pnpm install
	cp .env.example .env
	php artisan key:generate

Si tu utilises SQLite:

	mkdir -p database
	touch database/database.sqlite

Puis configure au minimum ton fichier .env:

	APP_URL=http://127.0.0.1:8000
	DB_CONNECTION=sqlite
	DB_DATABASE=database/database.sqlite
	QUEUE_CONNECTION=database

## 2) Lancer les migrations

	php artisan migrate

## 3) Lancer les seeders

	php artisan db:seed

Le seeder cree 2 utilisateurs de test:

- admin: example@gmail.com / 49610
- utilisateur MCP: mcp@mcpuser.com / 94951591

## 4) Lancer l application (web + vite)

Option A (tout en un, recommande):

	composer run dev

Cette commande demarre:

- serveur Laravel
- worker queue en mode listen
- logs (pail)
- Vite

Option B (manuel):

Terminal 1:

	php artisan serve

Terminal 2:

	pnpm dev

## 5) Lancer le worker de queue

Si tu ne passes pas par composer run dev, lance un worker dans un terminal dedie:

	php artisan queue:work

Pour verifier qu il tourne, fais un upvote sur une location connecte, puis surveille la sortie du worker.

## 6) Tester la commande planifiee

La commande metier est:

	php artisan app:purge-locations

Regle appliquee:

- supprime les locations creees il y a plus de 14 jours
- et ayant moins de 2 upvotes

Le scheduler execute cette commande tous les jours.

Pour tester manuellement:

	php artisan app:purge-locations

Pour tester le scheduler localement:

	php artisan schedule:list
	php artisan schedule:run

## 7) Configurer le login social (GitHub)

Cette application utilise Socialite avec GitHub.

### Etapes GitHub OAuth

1. Cree une OAuth App sur GitHub.
2. Mets ces URLs:
   - Homepage URL: http://127.0.0.1:8000
   - Authorization callback URL: http://127.0.0.1:8000/auth/github/callback
3. Recupere Client ID et Client Secret.

### Variables .env

	GITHUB_CLIENT_ID=ton_client_id
	GITHUB_CLIENT_SECRET=ton_client_secret
	GITHUB_REDIRECT_URI=http://127.0.0.1:8000/auth/github/callback

Routes utilisees:

- /auth/github/redirect
- /auth/github/callback

## 8) Configurer Stripe

Le projet utilise Laravel Cashier.

### Variables .env minimales

	STRIPE_KEY=pk_test_xxx
	STRIPE_SECRET=sk_test_xxx
	STRIPE_WEBHOOK_SECRET=whsec_xxx

Important:

- le prix Stripe est actuellement code en dur dans SubscriptionController:
  price_1TN76CAcRo8nDFi75NOtOU6q
- ce price doit exister dans ton compte Stripe test.

Flux de test:

1. Connecte-toi.
2. Ouvre /subscription.
3. Lance la souscription via le formulaire.
4. Utilise la carte de test Stripe:
   4242 4242 4242 4242

## 9) Generer et utiliser un token JWT pour l API

### Generer le secret JWT

	php artisan jwt:secret

Cela remplit JWT_SECRET dans .env.

### Recuperer un token

	curl -X POST http://127.0.0.1:8000/api/login \
	  -H "Content-Type: application/json" \
	  -d '{"email":"example@gmail.com","password":"49610"}'

La reponse contient un champ token.

### Appeler l API protegee

Route:

	GET /api/films/{film}/locations

Conditions d acces:

- token JWT valide (guard api)
- utilisateur avec abonnement Stripe actif

Exemple:

	curl http://127.0.0.1:8000/api/films/1/locations \
	  -H "Authorization: Bearer TON_TOKEN"

## 10) Lancer le MCP

Le serveur MCP enregistre:

- un serveur local nomme films
- un endpoint web /mcp/films

### Mode local (stdio)

	php artisan mcp:start films

### Mode web

Demarre Laravel puis expose l endpoint:

	http://127.0.0.1:8000/mcp/films

Outils disponibles:

- list_films
- get_locations_for_film

## Qualite de code

Formatter le code PHP avec Pint:

	./vendor/bin/pint