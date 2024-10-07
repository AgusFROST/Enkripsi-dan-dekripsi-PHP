<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/bootstrap.min.css">

    <title>Transposition Cipher Encryption & Decryption</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Transposition Cipher Encryption & Decryption</h1>
        <form method="POST" class="mt-4">
            <div class="form-group mt-4">
                <label for="message">Masukan text :</label>
                <input type="text" id="message" name="message" class="form-control" required>
            </div>
            <div class="form-group mt-4">
                <label for="key">Key:</label>
                <input type="text" id="key" name="key" class="form-control" required>
            </div>
            <div class="form-group mt-4">
                <label for="action">Operation :</label>
                <select id="action" name="action" class="form-control">
                    <option value="encrypt">Encrypt</option>
                    <option value="decrypt">Decrypt</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Submit</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $message = $_POST['message'];
            $key = $_POST['key'];
            $action = $_POST['action'];

            if ($action == "encrypt") {
                $result = encryptTranspositionCipher($message, $key);
                echo '<div class="alert alert-success mt-3">Encrypted Message: ' . $result . '</div>';
            } elseif ($action == "decrypt") {
                $result = decryptTranspositionCipher($message, $key);
                echo '<div class="alert alert-success mt-3">Decrypted Message: ' . $result . '</div>';
            }
        }

        function encryptTranspositionCipher($message, $key)
        {
            $keyLength = strlen($key);
            $message = str_replace(' ', '', $message); // Menghapus spasi
            $messageLength = strlen($message);
            $matrix = array();

            // Membuat matriks dari pesan
            for ($i = 0; $i < $keyLength; $i++) {
                $matrix[$i] = substr($message, $i * ceil($messageLength / $keyLength), ceil($messageLength / $keyLength));
            }

            $cipherText = "";
            // Mengambil karakter dari matriks berdasarkan urutan kunci
            for ($i = 0; $i < $keyLength; $i++) {
                $index = strpos(str_shuffle(str_repeat($key, 2)), $key[$i]);
                $cipherText .= isset($matrix[$index]) ? $matrix[$index] : '';
            }

            return $cipherText;
        }

        function decryptTranspositionCipher($message, $key)
        {
            $keyLength = strlen($key);
            $messageLength = strlen($message);
            $numCols = ceil($messageLength / $keyLength);
            $numRows = $keyLength;
            $decipheredMatrix = array_fill(0, $numRows, '');

            // Menentukan urutan kunci
            $keyOrder = array();
            for ($i = 0; $i < $keyLength; $i++) {
                $keyOrder[$i] = $key[$i];
            }
            array_multisort($keyOrder, SORT_ASC, array_keys($keyOrder));

            // Mengisi matriks berdasarkan urutan kunci
            for ($i = 0; $i < $numRows; $i++) {
                $decipheredMatrix[$keyOrder[$i]] = substr($message, $i * $numCols, $numCols);
            }

            // Membaca matriks untuk mendapatkan pesan asli
            $plainText = '';
            for ($i = 0; $i < $numCols; $i++) {
                for ($j = 0; $j < $numRows; $j++) {
                    if (isset($decipheredMatrix[$j][$i])) {
                        $plainText .= $decipheredMatrix[$j][$i];
                    }
                }
            }

            return $plainText;
        }
        ?>
        <a href="index.php" class="mt-5 btn btn-success">Kembali</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="asset/bootstrap.bundle.min.js"></script>
</body>

</html>