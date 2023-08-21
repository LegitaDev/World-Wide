<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="assests/css/all.min.css">
    <link rel="stylesheet" href="assests/css/bootstrap.min.css">
    <link rel="stylesheet" href="assests/css/style.css">
</head>

<body>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" href="index.php">World Wide</a>
        </li>
    </ul>

    <div class="landing">

        <form action="index.php" method="POST" class="form">
            <h2>Type Country Name</h2>
            <div class="mb-3">
                <label>Country</label>
                <input type="text" name="country" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>

    </div>
    <?php
    $submit = false;
    $resultFound = false;

    if (isset($_POST["submit"])) {
        $submit = true;

        if (empty($_POST["country"])) {
            echo "<div class=\"alert alert-danger\" role=\"alert\">";
            echo "Please fill up the country name.";
            echo "</div>";
        } else {
            $country = $_POST["country"];
            $url = "https://restcountries.com/v3.1/name/" . $country;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            $result = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($result, true);
            $result = json_decode(json_encode($result), FALSE);

            if ((!isset($result->status) && $result->status !== 404) && !empty($result)) {
                $resultFound = true;
            }
        }
    }
    ?>

    <?php if ($resultFound === true && $submit === true) : ?>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title m-b-0">Discover Countries !</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <?php for ($i = 0; $i < count($result); $i++) : ?>
                                    <?php if (strpos(strtolower($result[$i]->name->official), strtolower($country)) !== false) : ?>
                                        <?php (!empty($result[$i]->borders)) ? $landborderCountries = implode("-", $result[$i]->borders) : $landborderCountries = "none"; ?>
                                        <thead class="thead-light">
                                            <tr>
                                                <th> <label class="customcheckbox m-b-20"> <span class="checkmark"></span> </label> </th>
                                                <th scope="col">Country</th>
                                                <th scope="col">Official Name</th>
                                                <th scope="col">Currencies</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Region</th>
                                                <th scope="col">Language</th>
                                                <th scope="col">Land borders</th>
                                                <th scope="col">Maps</th>
                                                <th scope="col">Population</th>
                                                <th scope="col">Flag</th>
                                            </tr>
                                        </thead>
                                        <tbody class="customtable">
                                            <tr>
                                                <th> <label class="customcheckbox"> <input type="checkbox" class="listCheckbox"> <span class="checkmark"></span> </label> </th>
                                                <td><?php echo $result[$i]->name->common; ?></td>
                                                <td><?php echo $result[$i]->name->official; ?></td>
                                                <td><?php echo current($result[$i]->currencies)->name; ?></td>
                                                <td><?php echo $result[$i]->idd->root . $result[$i]->idd->suffixes[0]; ?></td>
                                                <td><?php echo $result[$i]->region; ?></td>
                                                <td><?php echo current($result[$i]->languages); ?></td>
                                                <td><?php echo $landborderCountries; ?></td>
                                                <td><a href='<?php echo $result[$i]->maps->googleMaps; ?>'>Maps"</a></td>
                                                <td><?php echo number_format($result[$i]->population) ?></td>
                                                <td><img src='<?php echo $result[$i]->flags->png; ?>' alt='flag' with='75' height='50'></td>
                                            </tr>
                                        </tbody>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    <?php else : ?>
        <div class="alert alert-danger" role="alert">
            no result found.
        </div>
    <?php endif; ?>



    <?php
    include_once("incl/footer.php");
    ?>
</body>

</html>