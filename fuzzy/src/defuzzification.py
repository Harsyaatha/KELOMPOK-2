
"""
Defuzzification - Fuzzy Mamdani

Metode:
1. Implikasi MIN (clipping)
2. Agregasi MAX
3. Defuzzifikasi Centroid
"""

import numpy as np
from scipy.integrate import trapezoid

from membership import (
    tidak_disarankan,
    dipertimbangkan,
    layak
)


def aggregate_output(alpha_values, resolution=0.01):
    """
    Melakukan clipping dan agregasi MAX
    pada seluruh fungsi keanggotaan output.

    alpha_values: dictionary hasil agregasi aturan.
    """

    z = np.arange(0, 100 + resolution, resolution)

    mu_tidak = np.array([
        min(tidak_disarankan(x), alpha_values["Tidak Disarankan"])
        for x in z
    ])

    mu_dipertimbangkan = np.array([
        min(dipertimbangkan(x), alpha_values["Dipertimbangkan"])
        for x in z
    ])

    mu_layak = np.array([
        min(layak(x), alpha_values["Layak"])
        for x in z
    ])

    # Komposisi menggunakan operator MAX
    mu_aggregate = np.maximum.reduce([
        mu_tidak,
        mu_dipertimbangkan,
        mu_layak
    ])

    return z, mu_aggregate


def centroid_defuzzification(z, mu_aggregate):
    """
    Menghitung nilai crisp menggunakan metode centroid.
    """

    luas = trapezoid(mu_aggregate, z)

    if luas == 0:
        raise ValueError(
            "Luas agregasi fuzzy bernilai nol."
        )

    momen = trapezoid(z * mu_aggregate, z)

    crisp = momen / luas

    return crisp, luas, momen
