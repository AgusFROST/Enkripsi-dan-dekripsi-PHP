<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/bootstrap.min.css">

    <title>Shift Cipher Encryption & Decryption</title>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Shift Cipher Encryption & Decryption</h2>
        <form action="" method="post" class="mt-4">

            <div class="form-group mt-4">
                <label for="text">Masukan Text:</label>
                <input type="text" id="text" name="text" class="form-control" required>
            </div>

            <div class="form-group mt-4">
                <label for="shift">Shift Value:</label>
                <input type="number" id="shift" name="shift" class="form-control" required>
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
            $text = $_POST['text'];
            $shift = $_POST['shift'];
            $operation = $_POST['operation'];

            // Fungsi enkripsi dan dekripsi menggunakan Shift Cipher
            function shiftCipher($text, $shift, $operation)
            {
                $result = '';
                $shift = $operation === 'encrypt' ? $shift : -$shift;

                for ($i = 0; $i < strlen($text); $i++) {
                    $char = $text[$i];

                    if (ctype_alpha($char)) {
                        $asciiOffset = ctype_upper($char) ? 65 : 97;
                        $newChar = chr(($asciiOffset + (ord($char) - $asciiOffset + $shift + 26) % 26));
                        $result .= $newChar;
                    } else {
                        $result .= $char;
                    }
                }
                return $result;
            }

            // Lakukan operasi enkripsi atau dekripsi
            $output = shiftCipher($text, $shift, $operation);

            echo '<div class="alert alert-success mt-4"><strong>Result:</strong> ' . htmlspecialchars($output) . '</div>';
        }
        ?>

        <a href="index.php" class="mt-5 btn btn-success">Kembali</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="asset/bootstrap.bundle.min.js"></script>
</body>

</html>