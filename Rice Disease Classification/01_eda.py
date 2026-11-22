
import os
import pandas as pd
import matplotlib.pyplot as plt
from PIL import Image

# Lokasi dataset
DATASET_DIR = r"..\..\dataset"

data = []

print("MEMERIKSA DATASET PENYAKIT PADI")
print("=" * 45)

# Membaca setiap kelas
for kelas in os.listdir(DATASET_DIR):
    folder_kelas = os.path.join(DATASET_DIR, kelas)

    if not os.path.isdir(folder_kelas):
        continue

    for nama_file in os.listdir(folder_kelas):
        path = os.path.join(folder_kelas, nama_file)

        try:
            with Image.open(path) as img:
                lebar, tinggi = img.size

                data.append({
                    "kelas": kelas,
                    "nama_file": nama_file,
                    "lebar": lebar,
                    "tinggi": tinggi,
                    "format": img.format
                })

        except Exception:
            print("Gambar tidak dapat dibaca:", path)

# Membuat DataFrame
df = pd.DataFrame(data)

print("\nJUMLAH GAMBAR SETIAP KELAS")
print(df["kelas"].value_counts())

print("\nINFORMASI UKURAN GAMBAR")
print(df[["lebar", "tinggi"]].describe())

# Visualisasi distribusi kelas
plt.figure(figsize=(8, 5))

df["kelas"].value_counts().plot(
    kind="bar",
    rot=0
)

plt.title("Distribusi Dataset Penyakit Padi")
plt.xlabel("Kelas Penyakit")
plt.ylabel("Jumlah Gambar")
plt.tight_layout()

os.makedirs("results", exist_ok=True)
plt.savefig("results/distribusi_dataset.png")
plt.show()

# Menampilkan contoh gambar
fig, axes = plt.subplots(1, 3, figsize=(12, 4))

for ax, kelas in zip(axes, df["kelas"].unique()):
    contoh = df[df["kelas"] == kelas].iloc[0]
    path = os.path.join(
        DATASET_DIR,
        kelas,
        contoh["nama_file"]
    )

    img = Image.open(path)
    ax.imshow(img)
    ax.set_title(kelas)
    ax.axis("off")

plt.tight_layout()
plt.savefig("results/contoh_gambar.png")
plt.show()

print("\nEDA SELESAI!")
