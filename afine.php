<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/bootstrap.min.css">

    <title>Affine Cipher Encryption & Decryption</title>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Affine Cipher Encryption & Decryption</h2>
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="message" class="form-label">Masukan text :</label>
                <input type="text" class="form-control" id="message" name="message" required>
            </div>
            <div class="mb-3">
                <label for="a" class="form-label">Key a (harus relatif prima dengan 26)</label>
                <input type="number" class="form-control" id="a" name="a" required>
            </div>
            <div class="mb-3">
                <label for="b" class="form-label">Key b</label>
                <input type="number" class="form-control" id="b" name="b" required>
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

        function gcd($a, $b)
        {
            if ($b == 0) {
                return $a;
            }
            return gcd($b, $a % $b);
        }

        function encrypt($msg, $a, $b)
        {
            $cipher = "";
            for ($i = 0; $i < strlen($msg); $i++) {
                if (ctype_alpha($msg[$i])) {
                    $offset = ctype_upper($msg[$i]) ? 65 : 97;
                    $cipher .= chr((($a * (ord($msg[$i]) - $offset) + $b) % 26) + $offset);
                } else {
                    $cipher .= $msg[$i];
                }
            }
            return $cipher;
        }

        function decrypt($cipher, $a, $b)
        {
            $msg = "";
            $a_inv = modInverse($a, 26);
            for ($i = 0; $i < strlen($cipher); $i++) {
                if (ctype_alpha($cipher[$i])) {
                    $offset = ctype_upper($cipher[$i]) ? 65 : 97;
                    $msg .= chr((($a_inv * ((ord($cipher[$i]) - $offset) - $b + 26)) % 26) + $offset);
                } else {
                    $msg .= $cipher[$i];
                }
            }
            return $msg;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $message = $_POST['message'];
            $a = intval($_POST['a']);
            $b = intval($_POST['b']);
            $action = $_POST['action'];

            if (gcd($a, 26) != 1) {
                echo '<div class="alert alert-danger mt-3">Error: Key a must be coprime with 26.</div>';
            } else {
                if ($action == "encrypt") {
                    $result = encrypt($message, $a, $b);
                    echo '<div class="alert alert-success mt-3">Encrypted Message: ' . $result . '</div>';
                } elseif ($action == "decrypt") {
                    $result = decrypt($message, $a, $b);
                    echo '<div class="alert alert-success mt-3">Decrypted Message: ' . $result . '</div>';
                }
            }
        }
        ?>
        <a href="index.php" class="mt-5 btn btn-success">Kembali</a>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="asset/bootstrap.bundle.min.js"></script>
</body>

</html>