<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/bootstrap.min.css">

    <title>Substitution Cipher Encryption & Decryption</title>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Substitution Cipher Encryption & Decryption</h2>
        <form action="" method="post" class="mt-4">

            <div class="form-group mt-4">
                <label for="text">Masukan Text:</label>
                <input type="text" id="text" name="text" class="form-control" required>
            </div>

            <div class="form-group mt-4">
                <label for="key">Masukan 26-character Substitution Key:</label>
                <input type="text" id="key" name="key" class="form-control" maxlength="26" required>
                <small class="form-text text-muted">Example Key: QWERTYUIOPASDFGHJKLZXCVBNM</small>
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
            $text = strtoupper($_POST['text']);
            $key = strtoupper($_POST['key']);
            $operation = $_POST['operation'];

            // Fungsi enkripsi dan dekripsi menggunakan Substitution Cipher
            function substitutionCipher($text, $key, $operation)
            {
                $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $result = '';

                if ($operation === 'decrypt') {
                    // Tukar key dan alphabet untuk dekripsi
                    $temp = $alphabet;
                    $alphabet = $key;
                    $key = $temp;
                }

                // Buat associative array untuk mapping karakter
                $substitutionMap = [];
                for ($i = 0; $i < 26; $i++) {
                    $substitutionMap[$alphabet[$i]] = $key[$i];
                }

                // Proses enkripsi/dekripsi
                for ($i = 0; $i < strlen($text); $i++) {
                    $char = $text[$i];
                    $result .= isset($substitutionMap[$char]) ? $substitutionMap[$char] : $char;
                }

                return $result;
            }

            // Validasi panjang kunci harus 26 karakter unik
            if (strlen($key) !== 26 || count(array_unique(str_split($key))) !== 26) {
                echo '<div class="alert alert-danger mt-4">Key must be exactly 26 unique characters!</div>';
            } else {
                // Lakukan operasi enkripsi atau dekripsi
                $output = substitutionCipher($text, $key, $operation);
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