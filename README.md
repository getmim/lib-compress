# lib-compress

Module yang menyediakan tools untuk kompresi brotli, gzip, dan webp

## Instalasi

Jalankan perintah berikut di folder aplikasi:

```bash
mim app install lib-compress
```

## Penggunaan

Pastikan menjalankan perintah `mim app server` untuk memastikan semua
extensi php sudah terpasang.

Semua aksi disimpan di class `LibCompress\Library\Compressor` dengan
method sebagai berikuta:

### brotli(string $file, string $target, int $quality=11): bool

### brotliContent(string $content, int $quality=11, int $mode=BROTLI_GENERIC): ?string

### gzip(string $file, string $target, string $mode='wb9'): bool

### gzipContent(string $content, int $level=9): ?string

### webp(string $file, string $target, int $quality=90): bool