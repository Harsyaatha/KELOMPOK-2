
from membership import (
    fuzzifikasi_harga,
    fuzzifikasi_rating
)

# Data studi kasus dari paper
harga = 349
rating = 81

# Proses fuzzifikasi
hasil_harga = fuzzifikasi_harga(harga)
hasil_rating = fuzzifikasi_rating(rating)

print("=" * 50)
print("PENGUJIAN FUZZIFIKASI FUZZY MAMDANI")
print("=" * 50)

print(f"\nHarga Game  : {harga}")
for kategori, nilai in hasil_harga.items():
    print(f"  {kategori:10s}: {nilai:.3f}")

print(f"\nRating Game : {rating}")
for kategori, nilai in hasil_rating.items():
    print(f"  {kategori:10s}: {nilai:.3f}")

print("\n" + "=" * 50)
