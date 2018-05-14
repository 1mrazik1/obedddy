    <?php
    define("CURRENT_PAGE", 'index');
    $title = 'Školská jedáleň';
    include 'header.php';
    ?>

    <section class="container">
        <h1>Aktuálna ponuka</h1>        <?php
        if (isset($_POST['order_foodId'])) {
        if (orderFood($_SESSION['userId'], filter_var($_POST['order_foodId'], FILTER_VALIDATE_INT))) {
        ?>
        <div class="alert alert-primary" role="alert">
            Úspešne objednané!
        </div>        <?php
        } else {
        ?>
        <div class="alert alert-danger" role="alert">
            Pri objednávaní došlo k chybe. Overte si, či máte dostatočný kredit.
        </div>        <?php
        }
        }
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Jedlo</th>
                    <th scope="col">Dátum</th>
                    <th scope="col">Cena</th>
                    <th scope="col">Akcia</th>
                </tr>
            </thead>
            <tbody>                <?php
                foreach (selectActiveFoods() as $key => $food) {
                ?>
                <tr>
                    <th scope="row"><?=$key + 1?>
                    </th>
                    <td><?=nl2br($food['description'])?>
                    </td>
                    <td><?=$food['date']?>
                    </td>
                    <td><?=FOOD_PRICE?>€
                    </td>
                    <td>
                        <form method="POST" class="form-inline pull-right">
                            <input type="hidden" name="order_foodId" value="<?=$food['id']?>" />
                            <button type="submit" class="btn btn-primary" <?=$currentBalance < FOOD_PRICE ? 'disabled' : ''?>>Objednať</button>
                        </form>
                    </td>
                </tr>                <?php
                }
                ?>

            </tbody>
        </table>
    </section>
    <?php if(isLoggedIn()): ?>
    <section class="container">
        <h1>Objednávky</h1>        <?php
        if (isset($_POST['cancel_orderId'])) {
        if (cancelOrder($_SESSION['userId'], filter_var($_POST['cancel_orderId'], FILTER_VALIDATE_INT))) {
        ?>
        <div class="alert alert-primary" role="alert">
            Objednávka zrušená!
        </div>        <?php
        } else {
        ?>
        <div class="alert alert-danger" role="alert">
            !!!
        </div>        <?php
        }
        }
        $orders = selectOrders($_SESSION['userId']);
        if (!$orders):
        echo "Žiadne objednávky";
        else:
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Objednané dňa</th>
                    <th scope="col">Jedlo</th>
                    <th scope="col">Dátum</th>
                    <th scope="col">Suma</th>
                    <th scope="col">Akcia</th>
                </tr>
            </thead>
            <tbody>                <?php
                foreach ($orders as $key => $order) {
                ?>
                <tr>
                    <td><?=$order['orderDate']?>
                    </td>
                    <td><?=nl2br($order['description'])?>
                    </td>
                    <td><?=$order['date']?>
                    </td>
                    <td><?=abs($order['sum'])?>€
                    </td>
                    <td>
                        <form method="POST" class="form-inline pull-right">
                            <input type="hidden" name="cancel_orderId" value="<?=$order['id']?>" />
                            <button type="submit" class="btn btn-danger">Zrušiť</button>
                        </form>
                    </td>
                </tr>                <?php
                }
                ?>
            </tbody>
        </table><?php endif; ?>
    </section>
    <?php endif; ?>

    <?php
    include 'footer.php';
    ?>
