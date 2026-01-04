# Docker Container Start Karne Ke Steps

## Step 1: Containers Build aur Start Karo
```bash
docker-compose up -d
```

## Step 2: Containers Status Check Karo
```bash
docker-compose ps
```

## Step 3: Application Access Karo
- Website: http://localhost:8080
- Admin Panel: http://localhost:8080/admin

## Step 4: Database Connect Karo (Agar Zarurat Ho)
- Host: localhost
- Port: 3307
- Username: root
- Password: root
- Database: portfolio

## Useful Commands

### Logs Dekhne Ke Liye
```bash
docker-compose logs -f
```

### Containers Stop Karne Ke Liye
```bash
docker-compose down
```

### Containers Stop aur Data Delete Karne Ke Liye
```bash
docker-compose down -v
```

