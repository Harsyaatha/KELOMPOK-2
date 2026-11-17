
"""
Membership Functions - Fuzzy Mamdani
Implementasi berdasarkan persamaan pada paper SINATTI 2025.

Variabel:
1. Harga: Murah, Sedang, Mahal
2. Rating: Rendah, Cukup, Tinggi
3. Output: Tidak Disarankan, Dipertimbangkan, Layak
"""


# ==================================================
# 1. FUNGSI KEANGGOTAAN HARGA
# ==================================================

def harga_murah(x):
    if x <= 300:
        return 1.0
    elif 300 < x < 400:
        return (400 - x) / 100
    else:
        return 0.0


def harga_sedang(x):
    if x <= 300 or x >= 700:
        return 0.0
    elif 300 < x < 500:
        return (x - 300) / 200
    elif 500 <= x < 700:
        return (700 - x) / 200
    return 0.0


def harga_mahal(x):
    if x <= 600:
        return 0.0
    elif 600 < x < 700:
        return (x - 600) / 100
    else:
        return 1.0


# ==================================================
# 2. FUNGSI KEANGGOTAAN RATING
# ==================================================

def rating_rendah(x):
    if x <= 50:
        return 1.0
    elif 50 < x < 60:
        return (60 - x) / 10
    else:
        return 0.0


def rating_cukup(x):
    if x <= 50 or x >= 85:
        return 0.0
    elif 50 < x < 70:
        return (x - 50) / 20
    elif 70 <= x < 85:
        return (85 - x) / 15
    return 0.0


def rating_tinggi(x):
    if x <= 75:
        return 0.0
    elif 75 < x < 90:
        return (x - 75) / 15
    else:
        return 1.0


# ==================================================
# 3. FUNGSI KEANGGOTAAN OUTPUT
# ==================================================

def tidak_disarankan(x):
    if x <= 40:
        return 1.0
    elif 40 < x < 60:
        return (60 - x) / 20
    else:
        return 0.0


def dipertimbangkan(x):
    if x <= 50 or x >= 80:
        return 0.0
    elif 50 < x < 70:
        return (x - 50) / 20
    elif 70 <= x < 80:
        return (80 - x) / 10
    return 0.0


def layak(x):
    if x <= 75:
        return 0.0
    elif 75 < x < 80:
        return (x - 75) / 5
    else:
        return 1.0



# ==================================================
# 4. PENGELOMPOKAN FUNGSI KEANGGOTAAN
# ==================================================

def fuzzifikasi_harga(x):
    return {
        "Murah": harga_murah(x),
        "Sedang": harga_sedang(x),
        "Mahal": harga_mahal(x)
    }


def fuzzifikasi_rating(x):
    return {
        "Rendah": rating_rendah(x),
        "Cukup": rating_cukup(x),
        "Tinggi": rating_tinggi(x)
    }


def fuzzifikasi_output(x):
    return {
        "Tidak Disarankan": tidak_disarankan(x),
        "Dipertimbangkan": dipertimbangkan(x),
        "Layak": layak(x)
    }
