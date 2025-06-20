# 🔐 Implementasi Kriptografi Klasik dalam PHP

Repositori ini berisi implementasi beberapa algoritma **kriptografi klasik** menggunakan **bahasa pemrograman PHP**, seperti:

- Shift Cipher (Caesar)
- Substitution Cipher
- Vigenère Cipher
- Affine Cipher
- Hill Cipher
- Transposition Cipher

Tujuannya adalah untuk mempelajari cara kerja dasar dari masing-masing cipher dan bagaimana mereka dapat diimplementasikan dalam bentuk kode yang sederhana namun efektif.

---

## 📚 Algoritma yang Diimplementasikan

### 1. 🔁 Shift Cipher (Caesar Cipher)
- Menggeser setiap huruf dalam plaintext sejauh *n* posisi di alfabet.
- Contoh: `A → D` jika shift = 3

### 2. 🔄 Substitution Cipher
- Mengganti setiap huruf dengan karakter tetap dari alfabet pengganti.
- Bisa berbentuk array statis atau pengacakan alfabet.

### 3. 🔑 Vigenère Cipher
- Cipher berbasis kata kunci menggunakan metode perulangan shift.
- Contoh: Plaintext: `HELLO`, Key: `KEY` → Enkripsi huruf per huruf berdasarkan huruf kunci.

### 4. 🧮 Affine Cipher
- Cipher berbasis rumus matematis: `E(x) = (ax + b) mod 26`
- a dan b adalah konstanta; a harus coprime terhadap 26.

### 5. 🧠 Hill Cipher
- Cipher berbasis aljabar linear (matriks).
- Mengubah plaintext menjadi vektor, lalu dikalikan matriks kunci modulo 26.

### 6. 🔀 Transposition Cipher
- Cipher yang mengubah urutan huruf tanpa mengubah huruf itu sendiri.
- Contoh: kolom, rail fence, atau metode zig-zag.

---

## 🛠️ Teknologi yang Digunakan

- PHP 8.x
- Tidak memerlukan framework
- Input/output sederhana (form, CLI, atau function)
