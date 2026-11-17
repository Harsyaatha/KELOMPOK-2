
def fuzzifikasi_harga(x):
    """
    Fungsi keanggotaan variabel harga.
    Domain: 0 - 1000 (ribu rupiah)
    """

    if not 0 <= x <= 1000:
        raise ValueError("Harga harus berada pada rentang 0-1000.")

    # Harga murah
    if x <= 300:
        murah = 1
    elif x < 400:
        murah = (400 - x) / 100
    else:
        murah = 0

    # Harga sedang
    if x <= 300 or x >= 700:
        sedang = 0
    elif x < 500:
        sedang = (x - 300) / 200
    else:
        sedang = (700 - x) / 200

    # Harga mahal
    if x <= 600:
        mahal = 0
    elif x < 700:
        mahal = (x - 600) / 100
    else:
        mahal = 1

    return {
        "Murah": murah,
        "Sedang": sedang,
        "Mahal": mahal
    }


def fuzzifikasi_rating(x):
    """
    Fungsi keanggotaan variabel rating.
    Domain: 0 - 100
    """

    if not 0 <= x <= 100:
        raise ValueError("Rating harus berada pada rentang 0-100.")

    # Rating rendah
    if x <= 50:
        rendah = 1
    elif x < 60:
        rendah = (60 - x) / 10
    else:
        rendah = 0

    # Rating cukup
    if x <= 50 or x >= 85:
        cukup = 0
    elif x < 70:
        cukup = (x - 50) / 20
    else:
        cukup = (85 - x) / 15

    # Rating tinggi
    if x <= 75:
        tinggi = 0
    elif x < 90:
        tinggi = (x - 75) / 15
    else:
        tinggi = 1

    return {
        "Rendah": rendah,
        "Cukup": cukup,
        "Tinggi": tinggi
    }


def fuzzifikasi_output(x):
    """
    Fungsi keanggotaan variabel output.
    Domain: 0 - 100
    """

    # Tidak disarankan: bahu kiri
    if x <= 40:
        tidak_disarankan = 1
    elif x < 60:
        tidak_disarankan = (60 - x) / 20
    else:
        tidak_disarankan = 0

    # Dipertimbangkan: segitiga
    if x <= 50 or x >= 80:
        dipertimbangkan = 0
    elif x < 65:
        dipertimbangkan = (x - 50) / 15
    else:
        dipertimbangkan = (80 - x) / 15

    # Layak: bahu kanan
    if x <= 75:
        layak = 0
    elif x < 80:
        layak = (x - 75) / 5
    else:
        layak = 1

    return {
        "Tidak Disarankan": tidak_disarankan,
        "Dipertimbangkan": dipertimbangkan,
        "Layak": layak
    }
