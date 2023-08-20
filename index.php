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

    if (isset($_POST["submit"])) {
        if (empty($_POST["country"])) {
            echo "Please fill up the country name.";
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

            if (!empty($result[0]->borders)) {
                $landborderCountries = implode("-", $result[0]->borders);
            } else {
                $landborderCountries = "none";
            }

            if (!empty($result)) {
                echo "<div class=\"container\">
                            <div class=\"row\">
                                <div class=\"col-12\">
                                    <div class=\"card\">
                                        <div class=\"card-body text-center\">
                                            <h5 class=\"card-title m-b-0\">Discover Countries !</h5>
                                        </div>
                                        <div class=\"table-responsive\">
                                            <table class=\"table\">
                                                <thead class=\"thead-light\">
                                                    <tr>
                                                        <th> <label class=\"customcheckbox m-b-20\"> <input type=\"checkbox\" id=\"mainCheckbox\"> <span class=\"checkmark\"></span> </label> </th>
                                                        <th scope=\"col\">Country</th>
                                                        <th scope=\"col\">Official Name</th>
                                                        <th scope=\"col\">Currencies</th>
                                                        <th scope=\"col\">Phone</th>
                                                        <th scope=\"col\">Region</th>
                                                        <th scope=\"col\">Language</th>
                                                        <th scope=\"col\">Land borders</th>
                                                        <th scope=\"col\">google Maps</th>
                                                        <th scope=\"col\">Population</th>
                                                        <th scope=\"col\">Flag</th>
    
    
                                                    </tr>
                                                </thead>
                                                <tbody class=\"customtable\">
                                                    <tr>
                                                        <th> <label class=\"customcheckbox\"> <input type=\"checkbox\" class=\"listCheckbox\"> <span class=\"checkmark\"></span> </label> </th>
                                                        <td>" . $result[0]->name->common . "</td>
                                                        <td>" . $result[0]->name->official . "</td>
                                                        <td>" . current($result[0]->currencies)->name . "</td>
                                                        <td>" . $result[0]->idd->root . $result[0]->idd->suffixes[0] . "</td>
                                                        <td>" . $result[0]->region . "</td>
                                                        <td>" . current($result[0]->languages) . "</td>
                                                        <td>" . $landborderCountries . "</td>
                                                        <td><a href='" . $result[0]->maps->googleMaps . "'>Maps" . "</a></td>
                                                        <td>" . number_format($result[0]->population) . "</td>
                                                        <td><img src='" . $result[0]->flags->png . "' alt='flag' with='75' height='50'></td>
    
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>";
            } else {
                echo "<div class='container'>";
                echo "not found";
                echo "</div>";
            }
        }
    }
    ?>
    <?php
    include_once("incl/footer.php");
    ?>
</body>

</html>