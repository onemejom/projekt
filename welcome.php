<?php
$servername = "localhost";
$username = "mentel";
$password = "Heslo123";
$dbname = "mentel3A2";

// Pripojenie k databáze
$connection = new mysqli($servername, $username, $password, $dbname);

// Kontrola pripojenia
if ($connection->connect_error) {
    die("Chyba pripojenie k db: " . $connection->connect_error);
}

// Predvolené hodnoty pre filtre
$cena_min = 0;
$cena_max = 9999;
$zoradenie = '';

// Kontrola, či boli odoslané filtre
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cena_min']) && $_POST['cena_min'] !== '') {
        $cena_min = $_POST['cena_min'];
    }
    if (isset($_POST['cena_max']) && $_POST['cena_max'] !== '') {
        $cena_max = $_POST['cena_max'];
    }
    if (isset($_POST['zoradenie']) && $_POST['zoradenie'] !== '') {
        $zoradenie = $_POST['zoradenie'];
    }
}

// Sestavenie SQL dotazu s použitím filtrov a zoradenia
$sql = "SELECT t_produkty.*, t_kategoria.kategoria 
        FROM t_produkty 
        INNER JOIN t_kategoria ON t_produkty.kategoria = t_kategoria.id 
        WHERE t_produkty.cena BETWEEN $cena_min AND $cena_max";

if ($zoradenie == 'asc') {
    $sql .= " ORDER BY nazov ASC";
} elseif ($zoradenie == 'desc') {
    $sql .= " ORDER BY nazov DESC";
}

$vysledok = $connection->query($sql);

if (!$vysledok) {
    die("Chyba v SQL dotaze: " . $connection->error);
}

$pocet = $vysledok->num_rows;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Produkty</title>
    <style>
        body {
            background-color: #f7f7f7;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .description {
            display: none;
        }

        .show-description {
            cursor: pointer;
            color: blue;
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Tabuľka produktov</h2>
    <!-- Formulár pre filtre a zoradenie -->
    <form method="post">
        <label for="cena_min">Minimálna cena:</label>
        <input type="number" name="cena_min" value="<?php echo htmlspecialchars($cena_min); ?>">
        <label for="cena_max">Maximálna cena:</label>
        <input type="number" name="cena_max" value="<?php echo htmlspecialchars($cena_max); ?>">
        <label for="zoradenie">Zoradiť:</label>
        <select name="zoradenie" id="zoradenie">
            <option value="" <?php echo $zoradenie == '' ? 'selected' : ''; ?>>Bez filtra</option>
            <option value="asc" <?php echo $zoradenie == 'asc' ? 'selected' : ''; ?>>Od A po Z</option>
            <option value="desc" <?php echo $zoradenie == 'desc' ? 'selected' : ''; ?>>Od Z po A</option>
        </select>
        <input type="submit" value="Filtrovať/Zoradiť">
    </form>
    <!-- Tabuľka s produktmi -->
    <table>
        <tr>
            <th>ID produktu</th>
            <th>Názov produktu</th>
            <th>Cena</th>
            <th>Cenová kategória</th>
            <th>Počet</th>
            <th>Popis produktu</th>
        </tr>
        <?php
        // Výpis produktov
        if ($pocet > 0) {
            while ($produkt = $vysledok->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $produkt['id'] . "</td>";
                echo "<td>" . $produkt['nazov'] . "</td>";
                echo "<td>" . $produkt['cena'] . "</td>";
                echo "<td>" . $produkt['kategoria'] . "</td>";
                echo "<td>" . $produkt['pocet'] . "</td>";
                echo "<td><span class='show-description' onclick='showDescription(this)'>Zobraziť popis</span>";
                echo "<div class='description'>" . $produkt['popis'] . "</div></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Žiadne výsledky</td></tr>";
        }
        ?>
    </table>
</div>

<script>
    function showDescription(element) {
        var description = element.nextElementSibling;
        if (description.style.display === "none") {
            description.style.display = "block";
            element.textContent = "Skryť popis";
        } else {
            description.style.display = "none";
            element.textContent = "Zobraziť popis";
        }
    }
</script>
</body>
</html>
