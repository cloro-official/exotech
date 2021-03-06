<?php 
include 'dbconfig.php';
include 'phpClass/dropdown.php';
include 'phpClass/card.php';

$dropdown = new Dropdown();

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ExoTech - Products</title>

        <link href="css/main.css?v=<?php echo time(); ?>" rel="stylesheet">
        
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="js/dropdown-menu.js?v=<?php echo time(); ?>"></script>
        <script src="js/card-behavior.js?v=<?php echo time(); ?>"></script>

    </head>
    <body class="flex flex-col">
        <?php 
            $cardview = new CardView();
        ?>
        <header class="z-50">
            <?php 
                $dropdown->createDropdown("Product");
            ?>
        </header>
        <main class="p-8">
            <p class="text-4xl font-semibold border-200-gray pb-2 mb-4 border-b-2">PRODUCTS<p>
            <form method="post" class="flex flex-row items-center" id="gen" name="gen" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <p class="text-center items-middle flex flex-row justify-center font-bold">Filter:</p>
                <select name="category" class="rounded-lg border-black font-bold border-2 mx-2 h-8" id="category">
                    <option value="All">All</option>
                    <option value="Processor">Processor</option>
                    <option value="RAM">RAM</option>
                    <option value="Motherboard">Motherboard</option>
                    <option value="SSD">SSD</option>
                    <option value="HDD">HDD</option>
                    <option value="PSU">PSU</option>
                    <option value="Cooling">Cooling</option>
                    <option value="Case">Case</option>
                    <option value="Monitor">Monitor</option>
                    <option value="Keyboard">Keyboard</option>
                    <option value="Mouse">Mouse</option>
                    <option value="Headset">Headset</option>
                    <option value="Smartphone">Smartphone</option>
                    <option value="Camera">Camera</option>
                    <option value="GPU">GPU</option>
                </select>
                <br><br>
                <input type="submit" class="mx-2 h-8 px-4 bg-black text-white font-bold rounded-lg" value="SUBMIT" name="submit" id="submit">
            </form>
            <div class="flex flex-wrap flex-row justify-around md:justify-start space-y-2">
                <?php 
                $json = json_decode(file_get_contents("products.json"), true);

                $category = isset($_POST['category']) ?$_POST['category'] : "All";
                if($category != "All"){
                    $sql = "SELECT * FROM `inventory` WHERE Category = '$category';";
                }elseif($category == "All"){
                    $sql = "SELECT * FROM `inventory`";
                }
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        new Card($row["Name"], $row["Price"], $row["Product_ID"], $json[$row["Product_ID"]] ?  $json[$row["Product_ID"]] : "https://image.flaticon.com/icons/png/512/984/984188.png");
                    }
                }
                ?>
            </div>
        </main>
        <footer class="footer-bg mt-8 px-64 flex flex-row py-8 justify-center items-center">
            <div class="flex flex-col flex-grow justify-center items-center">
                <p class="text-white font-semiboldbold">EXOTECH Philippines Co.<p>
                <p class="text-white font-semibold">000 Sample Street, Manila<p>
            </div>
            <div class="flex flex-col flex-grow justify-center items-center">
                <p class="text-white font-semibold">exotech.info@gmail.com<p>
                <p class="text-white font-semibold">+63 912 345 6789<p>
            </div>
            <div class="flex flex-col flex-grow justify-center items-center">
                <p class="text-white font-semibold">Created with PHP and Tailwind<p>
                <p class="text-white font-semibold">Cloalupat LTD.<p>
            </div>
        </footer>
    </body>
</html>