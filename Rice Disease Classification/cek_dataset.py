
import os

folder_dataset = "dataset"

print("\nHASIL PEMERIKSAAN DATASET")
print("=" * 40)

if not os.path.exists(folder_dataset):
    print("Folder dataset belum ditemukan!")
    print("Pastikan folder dataset berada di direktori project.")
else:
    for kelas in os.listdir(folder_dataset):
        lokasi_kelas = os.path.join(folder_dataset, kelas)

        if os.path.isdir(lokasi_kelas):
            gambar = []

            for root, dirs, files in os.walk(lokasi_kelas):
                for file in files:
                    if file.lower().endswith((".jpg", ".jpeg", ".png")):
                        gambar.append(file)

            print(f"{kelas}: {len(gambar)} gambar")

print("=" * 40)
