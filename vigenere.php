<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/bootstrap.min.css">

    <title>Vigenere Cipher Encryption & Decryption</title>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Vigenere Cipher Encryption & Decryption</h2>
        <form action="" method="post" class="mt-4">

            <div class="form-group mt-4">
                <label for="text">Masukan Text:</label>
                <input type="text" id="text" name="text" class="form-control" required>
            </div>

            <div class="form-group mt-4">
                <label for="key">Masukan Keyword:</label>
                <input type="text" id="key" name="key" class="form-control" required>
                <small class="form-text text-muted">Example Key: SECRET</small>
            </div>

            <div class="form-group mt-4">
                <label for="operation">Operation:</label>
                <select id="operation" name="operation" class="form-control" required>
                    <option value="encrypt">Encrypt</option>
                    <option value="decrypt">Decrypt</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Submit</button>
        </form>

        <?php
        // Cek apakah form disubmit
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $text = strtoupper(preg_replace('/[^A-Za-z]/', '', $_POST['text'])); // Menghapus karakter non-alfabet
            $key = strtoupper(preg_replace('/[^A-Za-z]/', '', $_POST['key']));   // Menghapus karakter non-alfabet
            $operation = $_POST['operation'];

            // Fungsi enkripsi dan dekripsi Vigenere Cipher
            function vigenereCipher($text, $key, $operation)
            {
                $result = '';
                $keyLength = strlen($key);
                $textLength = strlen($text);

                for ($i = 0; $i < $textLength; $i++) {
                    $textChar = $text[$i];
                    $keyChar = $key[$i % $keyLength];

                    if ($operation === 'encrypt') {
                        // Rumus enkripsi: (Pi + Ki) mod 26
                        $encryptedChar = chr(((ord($textChar) + ord($keyChar)) % 26) + 65);
                        $result .= $encryptedChar;
                    } else {
                        // Rumus dekripsi: (Ci - Ki + 26) mod 26
                        $decryptedChar = chr(((ord($textChar) - ord($keyChar) + 26) % 26) + 65);
                        $result .= $decryptedChar;
                    }
                }

                return $result;
            }

            // Validasi input
            if (empty($text) || empty($key)) {
                echo '<div class="alert alert-danger mt-4">Text and Key must contain only alphabetic characters!</div>';
            } else {
                // Lakukan operasi enkripsi atau dekripsi
                $output = vigenereCipher($text, $key, $operation);
                echo '<div class="alert alert-success mt-4"><strong>Result:</strong> ' . htmlspecialchars($output) . '</div>';
            }
        }
        ?>
        <a href="index.php" class="mt-5 btn btn-success">Kembali</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="asset/bootstrap.bundle.min.js"></script>
</body>

</html>