<?php 
    class Card {
        function __construct($name, $price, $id, $url) {
            echo "
                <div id='item-card' class='flex item-card flex-col justify-between rounded-lg h-64 w-64 min-h-64 min-w-64 max-h-64 max-w-64 p-4 mx-2 shadow-lg' value='$id'>
                    <img src='$url' class='h-32 h-min-32 h-max-32 flex-grow w-auto object-scale-down'>
                    <p class='font-bold py-1 border-200-gray border-b-2 flex-shrink-0 flex-grow-0'>$name<p>
                    <div class='flex flex-row flex-grow justify-between'>
                        <p class='font-semibold text-md'><strong>USD</strong> $price</p>
                        <button class='item-button p-px text-sm text-center px-2 font-semibold bg-200-gray view-button' value='{`name`: `$name`, `price`: $price, `id`: $id, `url`: `$url`}'>View</button>
                    </div>
                </div>";
        }
    }

    class CardView {
        function __construct() {
            $item = isset($_POST['selected-product']) ? $_POST['selected-product'] : "none";
            
            session_start();
            $conn = mysqli_connect("localhost", "root", "", "exotech");

            if ($item != "none") {
                $json = json_decode($item, true);
                $id = $json['id'];

                $conn->query("INSERT INTO `cart`(`Product_ID`) VALUES ($id); ");
                $_SESSION['postdata'] = $_POST;
                unset($_POST);
                header("Location: ".$_SERVER['PHP_SELF']);
            }

            echo '
            <form method="post" class="card-view-color hidden" id="card-view" action="' . $_SERVER["PHP_SELF"] . '">
                <input type="hidden" id="selected-product" name="selected-product" value="' .  "" . '">
                <div class="flex flex-col md:flex-row justify-center items-center fixed min-h-screen min-w-screen w-screen h-screen card-view-bg invisible">
                    <div class="flex flex-col md:flex-row justify-between card-view h-auto w-max-content bg-white rounded-2xl shadow-lg overflow-hidden">
                        <img id="card-view-img" src="" class="card-view-img p-4 justify-self-center flex-grow min-w-1/12 w-96 h-full object-contain">
                        <div class="flex-grow p-4 bg-400-gray h-32 flex justify-between content-between flex-col">
                            <p class="font-semibold text-2xl text-shadow-lg border-b-2 border-200-gray item-name">Item Name</p>
                            <p class="flex-grow text-top">Description</p>
                            <div class="flex flex-row justify-self-end justify-between">
                                <p class="font-semibold text-lg text-shadow-lg mt-2 self-start mx-2 price"><strong>USD </strong> 0.00</p>
                                <input type="submit" class="text-center py-1 px-4 border-2 font-bold border-black rounded-2xl card-button add-to-cart self-end mx-2" value="Add to Cart">
                                <a class="py-1 px-4 border-2 font-bold border-black rounded-2xl card-button back mx-2">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>';
        }
    }
?>