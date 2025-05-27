# Pixel Fox

Pixel Fox is a small web application powered by Laravel, RabbitMQ, Pusher and MySQL, configured using Docker for local development.
It uses a pyxelate tool https://github.com/sedthh/pyxelate/ to convert your image to pixel art.

![Demo](/src/public/images/pixelfox-org.gif)

## Getting Started

Follow these steps to set up the project on your local machine.

---

### 1. Copy and Configure `.env` Files

#### Main Directory

Copy the `.env-copy` file in the root directory and rename it to `.env`:

```bash
cp .env-copy .env
```

Edit the file and make sure to provide the following values:

```shell
USERNAME=user
GROUPNAME=user
RABBITMQ_DEFAULT_USER=guest
RABBITMQ_DEFAULT_PASS=guest
```
These variables are used for setting up Docker user permissions and RabbitMQ credentials.


#### Laravel (`src/`) Directory

Copy the `.env-copy` file inside the `src/` directory and rename it to `.env`:

```bash
cp src/.env-copy src/.env
```

Edit the file to match your database configuration and other Laravel environment settings including RabbitMQ settings and Pusher credentials.

---

### 2. Install SSL Certificates with `mkcert`

Install [`mkcert`](https://github.com/FiloSottile/mkcert) on your machine (if you haven’t already).

Then generate certificates:

```bash
mkcert -install
mkcert pixel-fox.test
```

Move the generated certificates (`pixel-fox.test.pem` and `pixel-fox.test-key.pem`) into the `nginx/ssl/` folder:

```bash
mv pixel-fox.test.pem nginx/ssl/
mv pixel-fox.test-key.pem nginx/ssl/
```

---

### 3. Start Docker Containers

In the project root directory, run:

```bash
docker-compose up -d
```

This will start the MySQL database, Laravel app, and Nginx server.

---

### 4. Install and Build Frontend vendor

On your host machine (not inside Docker), install Node dependencies and build the frontend assets:
```shell
cd src
npm install
npm run build
```
This step compiles JavaScript (including Echo + Pusher setup) and is required for broadcasting to work.

### 5. Run Laravel Migrations

Laravel migration will be executed automatically by docker-entrypoint.sh when the MySQL database will be ready.

---

### 6. Run queue

Run queue worker to process requests from the site. 

```shell
docker-compose exec app php artisan queue:work
```

### 7. Open the Application

Visit [`https://pixel-fox.test`](https://pixel-fox.test) in your browser.

Make sure `pixel-fox.test` points to `127.0.0.1` in your system's `/etc/hosts` file:

```
127.0.0.1 pixel-fox.test
```

---

## You're Ready!

You can now start working on the Pixel Fox project.
