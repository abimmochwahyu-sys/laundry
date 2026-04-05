# CLEANS3 API Documentation

## Authentication Endpoints

### POST /login
Login user dengan credentials.

**Request Body:**
```json
{
  "email": "user@example.com",
  "password": "password123"
}
```

**Response (Success):**
```json
{
  "success": true,
  "redirect": "/dashboard"
}
```

**Response (Error):**
```json
{
  "success": false,
  "message": "Email atau password salah"
}
```

### POST /register
Register user baru.

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "alamat": "Jl. Example No. 123",
  "telepon": "081234567890"
}
```

**Response (Success):**
```json
{
  "success": true,
  "redirect": "/login"
}
```

## Admin Endpoints

### GET /admin/dashboard
Dashboard admin dengan statistik.

**Response:**
```json
{
  "total_pelanggan": 150,
  "total_transaksi": 450,
  "pendapatan_bulan": 2500000,
  "transaksi_pending": 25
}
```

### GET /admin/pelanggan
List semua pelanggan.

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "telepon": "081234567890",
      "alamat": "Jl. Example",
      "created_at": "2024-01-01"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

### POST /admin/layanan
Buat layanan baru.

**Request Body:**
```json
{
  "jenis_layanan": "Cuci Kering Setrika",
  "harga": 15000,
  "estimasi_waktu": 3,
  "deskripsi": "Layanan cuci kering dan setrika"
}
```

### GET /admin/transaksi
List semua transaksi.

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "kode_transaksi": "TRX-20240101-001",
      "user": {
        "name": "John Doe"
      },
      "layanan": {
        "jenis_layanan": "Cuci Kering"
      },
      "berat": 2.5,
      "total_harga": 25000,
      "status_transaksi": "proses",
      "status_pembayaran": "lunas"
    }
  ]
}
```

## Customer Endpoints

### GET /pelanggan/dashboard
Dashboard pelanggan.

**Response:**
```json
{
  "user": {...},
  "recent_transaksi": [...],
  "total_transaksi": 5
}
```

### POST /pelanggan/transaksi
Buat transaksi baru.

**Request Body:**
```json
{
  "layanan_id": 1,
  "berat": 3.0,
  "metode_pembayaran": "cash"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Transaksi berhasil dibuat",
  "transaksi_id": 123
}
```

## Payment Integration

### Midtrans Payment Flow

1. **Create Transaction** → POST /pelanggan/transaksi
2. **Get Snap Token** → Sistem otomatis generate snap token
3. **Redirect to Midtrans** → User diarahkan ke payment page
4. **Payment Callback** → Midtrans kirim notifikasi ke sistem
5. **Update Status** → Sistem update status pembayaran

### Payment Status
- `pending` - Menunggu pembayaran
- `paid` - Sudah dibayar
- `failed` - Pembayaran gagal
- `lunas` - Sudah lunas (cash/manual)

## Error Responses

Semua error mengikuti format:
```json
{
  "success": false,
  "message": "Error message",
  "errors": {
    "field": ["Error detail"]
  }
}
```

## Status Codes
- `200` - Success
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `500` - Internal Server Error