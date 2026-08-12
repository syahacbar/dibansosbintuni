# Isolated Demo Application Deployment Guide

This document specifies the deployment configuration for running **DiBansos Bintuni** as an isolated demo application behind an Nginx reverse proxy.

---

## 1. Overview & Topography

- **Public URL**: `https://demo.kasuariweb.net/dibansos-teluk-bintuni/app`
- **Internal Upstream**: `127.0.0.1:8102`
- **Framework**: Laravel 12
- **Environment**: Isolated Demo Mode (`DEMO_MODE=true`)

The application runs as an isolated process bound to local loopback port 8102. An Nginx reverse proxy handles SSL termination, domain routing, and strips the subpath prefix before proxying incoming HTTP traffic upstream.

---

## 2. Production Environment Configuration (`.env`)

Configure the `.env` file on the production server as follows:

```env
APP_NAME="DIBANSOS BINTUNI"
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false
APP_URL=https://demo.kasuariweb.net/dibansos-teluk-bintuni/app
ASSET_URL=https://demo.kasuariweb.net/dibansos-teluk-bintuni/app

DEMO_MODE=true
DEMO_RESET_ALLOWED=true
DEMO_AUTO_RESET=false
DEMO_BASE_PATH=/dibansos-teluk-bintuni/app

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_PATH=/dibansos-teluk-bintuni/app
SESSION_DOMAIN=null
SESSION_SECURE_COOKIE=true
```

> [!NOTE]
> For standalone deployments or local development, keep `DEMO_MODE=false` and `DEMO_BASE_PATH=` (empty). The application will automatically serve from the root URL `/`.

---

## 3. Nginx Reverse Proxy Configuration

Nginx must strip `/dibansos-teluk-bintuni/app` before forwarding requests to `127.0.0.1:8102` and pass the `X-Forwarded-Prefix` header.

### Sample Nginx Server Block Configuration

```nginx
server {
    server_name demo.kasuariweb.net;

    # Public Subpath Proxy Configuration
    location /dibansos-teluk-bintuni/app/ {
        proxy_pass http://127.0.0.1:8102/;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_set_header X-Forwarded-Host $host;
        proxy_set_header X-Forwarded-Prefix /dibansos-teluk-bintuni/app;

        proxy_redirect off;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";
    }

    # Redirect /dibansos-teluk-bintuni/app to trailing slash
    location = /dibansos-teluk-bintuni/app {
        return 301 https://demo.kasuariweb.net/dibansos-teluk-bintuni/app/;
    }
}
```

---

## 4. Health Endpoint

- **Endpoint**: `GET /health`
- **Public URL**: `https://demo.kasuariweb.net/dibansos-teluk-bintuni/app/health`
- **Internal Upstream URL**: `http://127.0.0.1:8102/health`
- **Response**: `{"status":"ok"}` (HTTP Status 200 OK)

### Health Check Characteristics
- Requires **no authentication**.
- Performs **no database queries** or resource-intensive checks.
- Exposes **no environment variables**, secrets, `APP_KEY`, or diagnostic information.

---

## 5. Build & Cache Procedures

Execute the following commands during deployment:

### Asset Compilation
```bash
npm ci
npm run build
```

### Laravel Cache & Optimization
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan storage:link
```

### Clearing Caches (if updating config)
```bash
php artisan optimize:clear
```

---

## 6. Security & Safety Controls

1. **Trusted Proxy Scoping**: Only loopback addresses (`127.0.0.1`, `::1`) are permitted to supply forwarded headers (`X-Forwarded-Prefix`, `X-Forwarded-Host`, `X-Forwarded-Proto`).
2. **Demo Mode Safety**: `DEMO_MODE=true` flags the application as a demo instance. `DEMO_RESET_ALLOWED=true` is a reserved configuration flag; no public reset endpoint is active or exposed in this release.
3. **Session Cookie Isolation**: `SESSION_PATH=/dibansos-teluk-bintuni/app` ensures session cookies are restricted exclusively to the demo subpath and do not clash with other applications hosted on `demo.kasuariweb.net`.

---

## 7. Known Limitations

- **WebSockets / Reverb**: If WebSockets are added in future iterations, proxy configuration in Nginx will require explicit WebSocket upgrade rules under `/dibansos-teluk-bintuni/app/app/`.
- **Symlink Storage Path**: Public storage items rely on `php artisan storage:link` targeting `public/storage`. `ASSET_URL` ensures generated media links route through `https://demo.kasuariweb.net/dibansos-teluk-bintuni/app/storage/...`.
