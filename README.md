# Pixel Fox

Pixel Fox is a web application powered by Laravel and MySQL, configured using Docker for local development.

## Getting Started

Follow these steps to set up the project on your local machine.

---

### 1. Copy and Configure `.env` Files

#### Main Directory

Copy the `.env-copy` file in the root directory and rename it to `.env`:

```bash
cp .env-copy .env
```

Then, edit the file and fill in the database connection details.

#### Laravel (`src/`) Directory

Copy the `.env-copy` file inside the `src/` directory and rename it to `.env`:

```bash
cp src/.env-copy src/.env
```

Edit the file to match your database configuration and other Laravel environment settings including RabbitMQ settings.

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

### 4. Run Laravel Migrations

Access the Laravel container:

```bash
docker exec -it pixel-fox-app bash
```

Inside the container, run:

```bash
php artisan migrate
```

---

### 5. Open the Application

Visit [`https://pixel-fox.test`](https://pixel-fox.test) in your browser.

Make sure `pixel-fox.test` points to `127.0.0.1` in your system's `/etc/hosts` file:

```
127.0.0.1 pixel-fox.test
```

---

## You're Ready!

You can now start working on the Pixel Fox project.