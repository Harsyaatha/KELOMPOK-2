
import os
import pandas as pd
from sklearn.model_selection import train_test_split

# Lokasi dataset
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
DATASET_DIR = os.path.abspath(
    os.path.join(BASE_DIR, "..", "..", "dataset")
)

# Mengumpulkan lokasi gambar dan label
data = []

for kelas in os.listdir(DATASET_DIR):
    folder_kelas = os.path.join(DATASET_DIR, kelas)

    if not os.path.isdir(folder_kelas):
        continue

    for nama_file in os.listdir(folder_kelas):
        if nama_file.lower().endswith(
            (".jpg", ".jpeg", ".png")
        ):
            data.append({
                "filepath": os.path.join(
                    folder_kelas, nama_file
                ),
                "label": kelas
            })

df = pd.DataFrame(data)

# Membagi data 80% training dan 20% testing
train_df, test_df = train_test_split(
    df,
    test_size=0.2,
    random_state=42,
    stratify=df["label"]
)

# Membuat folder hasil
RESULT_DIR = os.path.join(BASE_DIR, "results")
os.makedirs(RESULT_DIR, exist_ok=True)

# Menyimpan hasil pembagian
train_df.to_csv(
    os.path.join(RESULT_DIR, "train_data.csv"),
    index=False
)

test_df.to_csv(
    os.path.join(RESULT_DIR, "test_data.csv"),
    index=False
)

# Menampilkan hasil
print("=" * 45)
print("HASIL PEMBAGIAN DATASET")
print("=" * 45)

print("\nData Training:")
print(train_df["label"].value_counts())

print("\nData Testing:")
print(test_df["label"].value_counts())

print("\nTotal Training:", len(train_df))
print("Total Testing:", len(test_df))
print("Total Dataset:", len(df))

print("\nPembagian dataset berhasil!")
