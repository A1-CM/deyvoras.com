# Deyvoras

Deyvoras is being set up as a Laravel application. The application scaffold and product features will be added separately.

## cPanel deployment

Deployment and rollback use the reusable Laravel workflows from [`A1-CM/.github`](https://github.com/A1-CM/.github), pinned to `v1.0.9`. Automatic deployment runs from `main` when Laravel application files change. The manual **Deploy Deyvoras to cPanel** action is also available after the Laravel application scaffold is added.

Configure these GitHub Actions repository or organization variables:

- `APP_URL`: the HTTPS origin, such as `https://deyvoras.com`
- `CPANEL_HOST`, `CPANEL_USERNAME`, and `CPANEL_HOME`
- `CPANEL_DOMAIN` if document-root lookup should use a specific hosted domain
- `CPANEL_PUBLIC_DIR` if the public directory should not be selected automatically
- `PHP_VERSION` if the cPanel PHP version differs from 8.3
- `CPANEL_HEALTH_PATH` if the health check should use a path other than Laravel's `/up`

Configure these Actions secrets:

- `CPANEL_API_TOKEN`: cPanel API token with the permissions needed by the deployer
- `MAIL_HOST`: mail server hostname used by the production Laravel app
- `APP_ENV_EXTRA`: optional newline-separated production environment entries, for example `OPENAI_API_KEY=...`

The caller uses `secrets: inherit`, so organization secrets must be available to this repository. The shared workflow installs dependencies, runs the Laravel test suite, builds Vite assets, prepares production Composer dependencies, provisions/updates the cPanel app database, deploys a release, runs migrations, and checks the configured health path. Database migrations are forward-only; take a database backup before schema changes. Confirm the domain's document root in cPanel before the first live deployment.

The rollback action is manual and restores one of the seven most recent healthy releases. Database changes are not rolled back with application files.
