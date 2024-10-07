<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/bootstrap.min.css">

    <title>Hill Cipher Encryption & Decryption</title>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Hill Cipher Encryption & Decryption</h2>
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="message" class="form-label">Pesan (Panjang harus merupakan kelipatan 3)</label>
                <input type="text" class="form-control" id="message" name="message" required>
            </div>
            <div class="mb-3">
                <label for="key_matrix" class="form-label">Key Matrix (Matriks 3x3, dipisahkan dengan tanda koma)</label>
                <p>example : 6,24,1,13,16,10,20,17,15</p>
                <input type="text" class="form-control" id="key_matrix" name="key_matrix" placeholder="Contoh: 6,24,1,13,16,10,20,17,15" required>
            </div>
            <div class="mb-3">
                <select name="action" class="form-select" required>
                    <option value="encrypt">Encrypt</option>
                    <option value="decrypt">Decrypt</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <?php
        function modInverse($a, $m)
        {
            $a = $a % $m;
            for ($x = 1; $x < $m; $x++) {
                if (($a * $x) % $m == 1) {
                    return $x;
                }
            }
            return 1;
        }

        function matrixMultiply($matrix, $vector, $modulus)
        {
            $result = [];
            for ($i = 0; $i < 3; $i++) {
                $result[$i] = 0;
                for ($j = 0; $j < 3; $j++) {
                    $result[$i] += $matrix[$i][$j] * $vector[$j];
                }
                $result[$i] %= $modulus;
            }
            return $result;
        }

        function encryptHillCipher($message, $keyMatrix)
        {
            $cipher = "";
            $msgLength = strlen($message);

            for ($i = 0; $i < $msgLength; $i += 3) {
                $vector = [ord($message[$i]) - 65, ord($message[$i + 1]) - 65, ord($message[$i + 2]) - 65];
                $result = matrixMultiply($keyMatrix, $vector, 26);

                foreach ($result as $res) {
                    $cipher .= chr(($res % 26) + 65);  // Convert to uppercase letter
                }
            }
            return $cipher;
        }

        function decryptHillCipher($cipher, $keyMatrix)
        {
            $decryptedMessage = "";
            $determinant = (($keyMatrix[0][0] * ($keyMatrix[1][1] * $keyMatrix[2][2] - $keyMatrix[1][2] * $keyMatrix[2][1]))
                - ($keyMatrix[0][1] * ($keyMatrix[1][0] * $keyMatrix[2][2] - $keyMatrix[1][2] * $keyMatrix[2][0]))
                + ($keyMatrix[0][2] * ($keyMatrix[1][0] * $keyMatrix[2][1] - $keyMatrix[1][1] * $keyMatrix[2][0]))) % 26;
            $determinant = ($determinant + 26) % 26;
            $determinantInverse = modInverse($determinant, 26);

            // Calculate adjugate matrix
            $adjugate = [
                [
                    ($keyMatrix[1][1] * $keyMatrix[2][2] - $keyMatrix[1][2] * $keyMatrix[2][1]) % 26,
                    ($keyMatrix[0][2] * $keyMatrix[2][1] - $keyMatrix[0][1] * $keyMatrix[2][2]) % 26,
                    ($keyMatrix[0][1] * $keyMatrix[1][2] - $keyMatrix[0][2] * $keyMatrix[1][1]) % 26
                ],

                [
                    ($keyMatrix[1][2] * $keyMatrix[2][0] - $keyMatrix[1][0] * $keyMatrix[2][2]) % 26,
                    ($keyMatrix[0][0] * $keyMatrix[2][2] - $keyMatrix[0][2] * $keyMatrix[2][0]) % 26,
                    ($keyMatrix[0][2] * $keyMatrix[1][0] - $keyMatrix[0][0] * $keyMatrix[1][2]) % 26
                ],

                [
                    ($keyMatrix[1][0] * $keyMatrix[2][1] - $keyMatrix[1][1] * $keyMatrix[2][0]) % 26,
                    ($keyMatrix[0][1] * $keyMatrix[2][0] - $keyMatrix[0][0] * $keyMatrix[2][1]) % 26,
                    ($keyMatrix[0][0] * $keyMatrix[1][1] - $keyMatrix[0][1] * $keyMatrix[1][0]) % 26
                ]
            ];

            // Calculate inverse matrix mod 26
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    $adjugate[$i][$j] = ($adjugate[$i][$j] * $determinantInverse) % 26;
                    if ($adjugate[$i][$j] < 0) {
                        $adjugate[$i][$j] += 26;
                    }
                }
            }

            // Decrypt the message
            for ($i = 0; $i < strlen($cipher); $i += 3) {
                $vector = [ord($cipher[$i]) - 65, ord($cipher[$i + 1]) - 65, ord($cipher[$i + 2]) - 65];
                $result = matrixMultiply($adjugate, $vector, 26);

                foreach ($result as $res) {
                    $decryptedMessage .= chr(($res % 26) + 65);  // Convert to uppercase letter
                }
            }
            return $decryptedMessage;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $message = strtoupper(trim($_POST['message'])); // Convert to uppercase
            $keyMatrixInput = $_POST['key_matrix'];
            $action = $_POST['action'];

            // Pad message with 'X' if its length is not a multiple of 3
            $length = strlen($message);
            while ($length % 3 != 0) {
                $message .= 'X';  // Add 'X' to make the length a multiple of 3
                $length++;
            }

            $keyMatrixValues = array_map('intval', explode(',', $keyMatrixInput));
            if (count($keyMatrixValues) != 9) {
                echo '<div class="alert alert-danger mt-3">Error: Key matrix must be 3x3.</div>';
            } else {
                $keyMatrix = [
                    [$keyMatrixValues[0], $keyMatrixValues[1], $keyMatrixValues[2]],
                    [$keyMatrixValues[3], $keyMatrixValues[4], $keyMatrixValues[5]],
                    [$keyMatrixValues[6], $keyMatrixValues[7], $keyMatrixValues[8]],
                ];

                if ($action == "encrypt") {
                    $result = encryptHillCipher($message, $keyMatrix);
                    echo '<div class="alert alert-success mt-3">Encrypted Message: ' . $result . '</div>';
                } elseif ($action == "decrypt") {
                    $result = decryptHillCipher($message, $keyMatrix);
                    echo '<div class="alert alert-success mt-3">Decrypted Message: ' . $result . '</div>';
                }
            }
        }
        ?>
        <a href="index.php" class="mt-5 btn btn-success">Kembali</a>
    </div>

    <script src="asset/bootstrap.bundle.min.js"></script>
</body>

</html>