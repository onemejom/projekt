<?php
session_start(); // Start the session

$servername = "localhost";
$username = "oliver";
$password = "koberec";
$dbname = "slezak3a2";

// Pripojenie k databáze
$connection = new mysqli($servername, $username, $password, $dbname);

// Kontrola pripojenia
if ($connection->connect_error) {
    die("Chyba pripojenie k db: " . $connection->connect_error);
}

// Predvolené hodnoty pre filtre
$cena_min = 0;
$cena_max = 999;
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
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: index.php"); // Redirect to login page after logout
        exit();
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
} elseif ($zoradenie == 'price_asc') {
    $sql .= " ORDER BY cena ASC";
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
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }

        .header {
            background-color: #00796b;
            color: white;
            padding: 10px 0;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .container {
            display: flex;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .sidebar {
            width: 250px;
            padding: 20px;
            background-color: #fafafa;
            border-right: 1px solid #ddd;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }

        h2 {
            color: #00796b;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            color: #00796b;
        }

        input[type="number"], select {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="submit"], input[type="button"] {
            background-color: #00796b;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover, input[type="button"]:hover {
            background-color: #004d40;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #00796b;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .description {
            display: none;
            font-size: 12px;
            color: #666;
        }

        .show-description {
            cursor: pointer;
            color: #00796b;
            text-decoration: underline;
            font-size: 14px;
        }

        .show-description:hover {
            color: #004d40;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>Produkty</h1>
</div>
<div class="container">
    <div class="sidebar">
        <form method="post">
            <h2>Filtre</h2>
            <label for="cena_min">Minimálna cena:</label>
            <input type="number" name="cena_min" value="<?php echo htmlspecialchars($cena_min); ?>">
            <label for="cena_max">Maximálna cena:</label>
            <input type="number" name="cena_max" value="<?php echo htmlspecialchars($cena_max); ?>">
            <label for="zoradenie">Zoradiť:</label>
            <select name="zoradenie" id="zoradenie">
                <option value="" <?php echo $zoradenie == '' ? 'selected' : ''; ?>>Bez filtra</option>
                <option value="asc" <?php echo $zoradenie == 'asc' ? 'selected' : ''; ?>>Od A po Z</option>
                <option value="desc" <?php echo $zoradenie == 'desc' ? 'selected' : ''; ?>>Od Z po A</option>
                <option value="price_asc" <?php echo $zoradenie == 'price_asc' ? 'selected' : ''; ?>>Od najnižšej ceny</option>
            </select>
            <input type="submit" value="Filtrovať/Zoradiť">
            <input type="submit" name="logout" value="Odhlásiť sa">
        </form>
    </div>
    <div class="content">
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