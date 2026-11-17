
from membership import (
    fuzzifikasi_harga,
    fuzzifikasi_rating
)

from rules import (
    evaluate_rules,
    aggregate_rules
)

from defuzzification import (
    aggregate_output,
    centroid_defuzzification
)


# ==========================================
# 1. DATA STUDI KASUS
# ==========================================

nama_game = "Cyberpunk 2077: Phantom Liberty"
harga = 349
rating = 81


# ==========================================
# 2. FUZZIFIKASI
# ==========================================

mu_harga = fuzzifikasi_harga(harga)
mu_rating = fuzzifikasi_rating(rating)


# ==========================================
# 3. INFERENSI FUZZY
# ==========================================

rule_results = evaluate_rules(
    mu_harga,
    mu_rating
)

alpha_values = aggregate_rules(rule_results)


# ==========================================
# 4. AGREGASI KURVA OUTPUT
# ==========================================

z, mu_aggregate = aggregate_output(
    alpha_values,
    resolution=0.01
)


# ==========================================
# 5. DEFUZZIFIKASI CENTROID
# ==========================================

crisp, luas, momen = centroid_defuzzification(
    z,
    mu_aggregate
)


# ==========================================
# 6. MENAMPILKAN HASIL
# ==========================================

print("=" * 60)
print("HASIL DEFUZZIFIKASI FUZZY MAMDANI")
print("=" * 60)

print(f"Nama Game : {nama_game}")
print(f"Harga     : {harga}")
print(f"Rating    : {rating}")

print("\nHASIL AGREGASI OUTPUT")

for kategori, nilai in alpha_values.items():
    print(f"{kategori:20s}: {nilai:.3f}")

print("\nHASIL CENTROID")

print(f"Luas agregasi  : {luas:.6f}")
print(f"Momen agregasi : {momen:.6f}")
print(f"Nilai Crisp    : {crisp:.2f}")

print("\n" + "=" * 60)
