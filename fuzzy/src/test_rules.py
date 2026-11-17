
from membership import (
    fuzzifikasi_harga,
    fuzzifikasi_rating
)

from rules import (
    evaluate_rules,
    aggregate_rules
)


# Data Cyberpunk 2077 dari paper
harga = 349
rating = 81


# Tahap fuzzifikasi
mu_harga = fuzzifikasi_harga(harga)
mu_rating = fuzzifikasi_rating(rating)


# Tahap evaluasi aturan
rule_results = evaluate_rules(
    mu_harga,
    mu_rating
)


print("=" * 65)
print("HASIL INFERENSI FUZZY MAMDANI")
print("=" * 65)

print("\nDERAJAT AKTIVASI SEMBILAN ATURAN")

for result in rule_results:
    print(
        f"{result['rule']} | "
        f"Harga: {result['harga']:5s} | "
        f"Rating: {result['rating']:6s} | "
        f"Output: {result['output']:20s} | "
        f"Alpha: {result['alpha']:.3f}"
    )


# Tahap agregasi MAX
aggregated = aggregate_rules(rule_results)

print("\nHASIL AGREGASI OUTPUT (MAX)")

for kategori, nilai in aggregated.items():
    print(f"{kategori:20s}: {nilai:.3f}")

print("\n" + "=" * 65)
