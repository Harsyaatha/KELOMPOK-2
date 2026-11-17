
"""
Rule Base - Fuzzy Mamdani
Berdasarkan sembilan aturan pada paper SINATTI 2025.
"""

# Sembilan aturan IF-THEN
RULES = [
    ("Murah", "Rendah", "Tidak Disarankan"),       # R1
    ("Murah", "Cukup", "Dipertimbangkan"),         # R2
    ("Murah", "Tinggi", "Layak"),                  # R3

    ("Sedang", "Rendah", "Tidak Disarankan"),     # R4
    ("Sedang", "Cukup", "Dipertimbangkan"),       # R5
    ("Sedang", "Tinggi", "Layak"),                # R6

    ("Mahal", "Rendah", "Tidak Disarankan"),      # R7
    ("Mahal", "Cukup", "Dipertimbangkan"),        # R8
    ("Mahal", "Tinggi", "Layak")                  # R9
]


def evaluate_rules(harga_fuzzy, rating_fuzzy):
    """
    Mengevaluasi sembilan aturan menggunakan operator MIN.

    Parameter:
        harga_fuzzy  : dictionary derajat keanggotaan harga
        rating_fuzzy : dictionary derajat keanggotaan rating

    Return:
        List hasil aktivasi setiap aturan.
    """

    results = []

    for index, (harga, rating, output) in enumerate(RULES, start=1):

        # Operator AND menggunakan MIN
        alpha = min(
            harga_fuzzy[harga],
            rating_fuzzy[rating]
        )

        results.append({
            "rule": f"R{index}",
            "harga": harga,
            "rating": rating,
            "output": output,
            "alpha": alpha
        })

    return results


def aggregate_rules(rule_results):
    """
    Menggabungkan aturan dengan output yang sama
    menggunakan operator MAX.
    """

    aggregated = {
        "Tidak Disarankan": 0.0,
        "Dipertimbangkan": 0.0,
        "Layak": 0.0
    }

    for result in rule_results:
        output = result["output"]
        alpha = result["alpha"]

        aggregated[output] = max(
            aggregated[output],
            alpha
        )

    return aggregated
