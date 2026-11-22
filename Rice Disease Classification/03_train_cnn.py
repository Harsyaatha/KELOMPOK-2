
import os
import json
import numpy as np
import pandas as pd
import tensorflow as tf
import matplotlib.pyplot as plt

from sklearn.model_selection import train_test_split
from sklearn.metrics import (
    classification_report,
    confusion_matrix,
    ConfusionMatrixDisplay
)

# =====================================
# 1. PERSIAPAN
# =====================================

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
RESULT_DIR = os.path.join(BASE_DIR, "results")
MODEL_DIR = os.path.join(BASE_DIR, "models")

os.makedirs(RESULT_DIR, exist_ok=True)
os.makedirs(MODEL_DIR, exist_ok=True)

IMG_SIZE = (160, 160)
BATCH_SIZE = 8
EPOCHS = 30

print("TensorFlow version:", tf.__version__)

# =====================================
# 2. MEMBACA DATASET CSV
# =====================================

train_df = pd.read_csv(
    os.path.join(RESULT_DIR, "train_data.csv")
)

test_df = pd.read_csv(
    os.path.join(RESULT_DIR, "test_data.csv")
)

class_names = sorted(train_df["label"].unique())

class_to_index = {
    name: index
    for index, name in enumerate(class_names)
}

print("\nDaftar kelas:", class_names)

# Membagi training dan validation
train_part, val_part = train_test_split(
    train_df,
    test_size=0.2,
    random_state=42,
    stratify=train_df["label"]
)

print("\nJumlah training:", len(train_part))
print("Jumlah validation:", len(val_part))
print("Jumlah testing:", len(test_df))

# =====================================
# 3. MEMBACA DAN PREPROCESSING GAMBAR
# =====================================

def load_image(path, label):
    image = tf.io.read_file(path)

    image = tf.io.decode_image(
        image,
        channels=3,
        expand_animations=False
    )

    image.set_shape([None, None, 3])

    image = tf.image.resize(image, IMG_SIZE)

    return image, label


def create_dataset(dataframe, training=False):

    paths = dataframe["filepath"].values

    labels = np.array([
        class_to_index[label]
        for label in dataframe["label"]
    ])

    dataset = tf.data.Dataset.from_tensor_slices(
        (paths, labels)
    )

    if training:
        dataset = dataset.shuffle(
            buffer_size=len(dataframe),
            seed=42
        )

    dataset = dataset.map(
        load_image,
        num_parallel_calls=tf.data.AUTOTUNE
    )

    dataset = dataset.batch(BATCH_SIZE)

    dataset = dataset.prefetch(tf.data.AUTOTUNE)

    return dataset


train_ds = create_dataset(train_part, training=True)
val_ds = create_dataset(val_part)
test_ds = create_dataset(test_df)

# =====================================
# 4. MEMBANGUN MODEL CNN
# =====================================

augmentation = tf.keras.Sequential([
    tf.keras.layers.RandomFlip("horizontal"),
    tf.keras.layers.RandomRotation(0.08),
    tf.keras.layers.RandomZoom(0.10)
])

model = tf.keras.Sequential([

    tf.keras.Input(shape=(160, 160, 3)),

    augmentation,

    tf.keras.layers.Rescaling(1./255),

    # Convolution block 1
    tf.keras.layers.Conv2D(
        32, (3, 3), activation="relu"
    ),
    tf.keras.layers.MaxPooling2D((2, 2)),

    # Convolution block 2
    tf.keras.layers.Conv2D(
        64, (3, 3), activation="relu"
    ),
    tf.keras.layers.MaxPooling2D((2, 2)),

    # Convolution block 3
    tf.keras.layers.Conv2D(
        128, (3, 3), activation="relu"
    ),
    tf.keras.layers.MaxPooling2D((2, 2)),

    # Classification
    tf.keras.layers.GlobalAveragePooling2D(),

    tf.keras.layers.Dropout(0.4),

    tf.keras.layers.Dense(
        64, activation="relu"
    ),

    tf.keras.layers.Dense(
        len(class_names),
        activation="softmax"
    )
])

model.compile(
    optimizer="adam",
    loss="sparse_categorical_crossentropy",
    metrics=["accuracy"]
)

print("\nARSITEKTUR MODEL CNN")
model.summary()

# =====================================
# 5. TRAINING MODEL
# =====================================

early_stopping = tf.keras.callbacks.EarlyStopping(
    monitor="val_loss",
    patience=6,
    restore_best_weights=True
)

history = model.fit(
    train_ds,
    validation_data=val_ds,
    epochs=EPOCHS,
    callbacks=[early_stopping]
)

# =====================================
# 6. EVALUASI DATA TESTING
# =====================================

test_loss, test_accuracy = model.evaluate(test_ds)

print("\nHASIL EVALUASI")
print("Test Loss:", test_loss)
print("Test Accuracy:", test_accuracy)

# Prediksi
y_true = np.concatenate([
    labels.numpy()
    for images, labels in test_ds
])

predictions = model.predict(test_ds)

y_pred = np.argmax(predictions, axis=1)

print("\nCLASSIFICATION REPORT")
print(
    classification_report(
        y_true,
        y_pred,
        labels=np.arange(len(class_names)),
        target_names=class_names,
        zero_division=0
    )
)

# =====================================
# 7. CONFUSION MATRIX
# =====================================

cm = confusion_matrix(
    y_true,
    y_pred,
    labels=np.arange(len(class_names))
)

display = ConfusionMatrixDisplay(
    confusion_matrix=cm,
    display_labels=class_names
)

fig, ax = plt.subplots(figsize=(8, 6))

display.plot(
    ax=ax,
    cmap="Blues",
    xticks_rotation=30
)

plt.title("Confusion Matrix - Rice Disease CNN")
plt.tight_layout()

plt.savefig(
    os.path.join(RESULT_DIR, "confusion_matrix.png")
)

plt.show()

# =====================================
# 8. GRAFIK TRAINING
# =====================================

plt.figure(figsize=(12, 5))

plt.subplot(1, 2, 1)

plt.plot(history.history["accuracy"], label="Training")
plt.plot(history.history["val_accuracy"], label="Validation")

plt.title("Model Accuracy")
plt.xlabel("Epoch")
plt.ylabel("Accuracy")
plt.legend()

plt.subplot(1, 2, 2)

plt.plot(history.history["loss"], label="Training")
plt.plot(history.history["val_loss"], label="Validation")

plt.title("Model Loss")
plt.xlabel("Epoch")
plt.ylabel("Loss")
plt.legend()

plt.tight_layout()

plt.savefig(
    os.path.join(RESULT_DIR, "training_history.png")
)

plt.show()

# =====================================
# 9. SIMPAN MODEL
# =====================================

model.save(
    os.path.join(MODEL_DIR, "rice_disease_cnn.keras")
)

with open(
    os.path.join(MODEL_DIR, "class_names.json"),
    "w"
) as file:
    json.dump(class_names, file)

print("\nTraining selesai!")
print("Model berhasil disimpan.")
