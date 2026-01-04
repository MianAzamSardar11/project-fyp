# Docker Setup Guide for Sociavo

## Prerequisites
- Docker installed on your system
- Docker Compose installed

## Quick Start

### 1. Build and Start Containers
```bash
docker-compose up -d
```

This will:
- Build the PHP Apache container
- Start MySQL database container
- Initialize the database with the SQL dump file

### 2. Access the Application
- **Frontend**: http://localhost:8080
- **Admin Panel**: http://localhost:8080/admin
- **MySQL**: localhost:3307
  - Username: `root`
  - Password: `root`
  - Database: `portfolio`

### 3. Stop Containers
```bash
docker-compose down
```

### 4. Stop and Remove Volumes (Clean Reset)
```bash
docker-compose down -v
```

## Container Details

### Web Container (PHP Apache)
- Port: 8080 (mapped to container's port 80)
- PHP Version: 8.2
- Extensions: mysqli, pdo_mysql, mbstring, gd, etc.
- Volumes: Project files are mounted for live development

### Database Container (MySQL)
- Port: 3307 (mapped to container's port 3306)
- MySQL Version: 8.0
- Root Password: `root`
- Database: `portfolio`
- Auto-initializes from `admin/db/portfolio.sql`

## Environment Variables

You can customize the database connection by creating a `.env` file:

```env
DB_HOST=db
DB_USER=root
DB_PASSWORD=root
DB_NAME=portfolio
```

## Useful Commands

### View Logs
```bash
# All services
docker-compose logs -f

# Web service only
docker-compose logs -f web

# Database service only
docker-compose logs -f db
```

### Access Container Shell
```bash
# PHP container
docker exec -it sociavo-web bash

# MySQL container
docker exec -it sociavo-db bash
```

### MySQL Command Line
```bash
docker exec -it sociavo-db mysql -uroot -proot portfolio
```

### Rebuild Containers
```bash
docker-compose up -d --build
```

## Troubleshooting

### Port Already in Use
If port 8080 or 3307 is already in use, edit `docker-compose.yml` and change the port mappings:
```yaml
ports:
  - "8081:80"  # Change 8080 to 8081
```

### Database Connection Issues
- Make sure the database container is running: `docker-compose ps`
- Check database logs: `docker-compose logs db`
- Verify environment variables are set correctly

### Permission Issues
If you face file permission issues:
```bash
docker exec -it sociavo-web chown -R www-data:www-data /var/www/html
docker exec -it sociavo-web chmod -R 755 /var/www/html
```

## Development vs Production

For **production**, consider:
1. Using environment-specific configurations
2. Not exposing MySQL port publicly
3. Using secrets management for passwords
4. Setting up proper SSL/TLS certificates
5. Using production-ready PHP configuration


