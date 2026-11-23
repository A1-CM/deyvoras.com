# Deyvoras

Deyvoras is a Laravel contract intelligence workspace for organizing agreements, recording key terms, and tracking reviews and obligations. The interface follows the device color preference: light devices get a white canvas with black text, and dark devices get the inverse.

## Local setup

Requires PHP 8.3+, Composer, Node.js 20.19+ (or 22.12+), and the PHP SQLite extension.

```sh
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
npm ci
npm run build
php artisan serve
```

Create a workspace through **Create workspace**. Owners can invite teammates with single-use links that expire after seven days. Legal reviewers and contract managers can add contracts, privately upload source files, record clause details, mark clause records as checked against the source, and track obligations. Read-only members can view records. Contract records are scoped to their organization. Source documents retain version history and use Laravel's private local disk by default.

The first release stores user-reviewed contract information. It does not extract terms automatically, provide legal advice, determine legal validity, or integrate external legal systems. Entered clause details and summaries should be verified against the source agreement.

## Product landing page

The landing page introduces Deyvoras, its agreement workflow, product features, illustrative team perspectives, current and planned pricing, and frequently asked questions. Testimonials are clearly identified as illustrative until verified customer quotes are available. The current workspace is free; no paid subscription is sold through the site.

## cPanel deployment

Deployment and rollback use the reusable Laravel workflows from [`A1-CM/.github`](https://github.com/A1-CM/.github), pinned to `v1.0.9`. Automatic deployment runs from `main` when Laravel application files change. The manual **Deploy Deyvoras to cPanel** action is also available.

Configure these GitHub Actions repository or organization variables:

- `APP_URL`: the HTTPS origin, such as `https://deyvoras.com`
- `CPANEL_HOST`, `CPANEL_USERNAME`, and `CPANEL_HOME`
- `CPANEL_DOMAIN` if document-root lookup should use a specific hosted domain
- `CPANEL_PUBLIC_DIR` if the public directory should not be selected automatically
- `PHP_VERSION` if cPanel PHP differs from 8.3
- `CPANEL_HEALTH_PATH` if the health check should use a path other than `/up`

Configure these Actions secrets:

- `CPANEL_API_TOKEN`: cPanel API token with the permissions needed by the deployer
- `MAIL_HOST`: mail server hostname used by the production Laravel app
- `APP_ENV_EXTRA`: optional newline-separated production environment entries

The caller uses `secrets: inherit`, so organization secrets must be available to this repository. The shared workflow installs dependencies, runs tests, builds Vite assets, prepares production Composer dependencies, provisions/updates the cPanel app database, deploys a release, runs migrations, and checks the configured health path. Database migrations are forward-only; back up the database before schema changes. Confirm the domain's document root in cPanel before the first live deployment.
