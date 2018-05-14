<?php
define("CURRENT_PAGE", 'history');
$title = 'História transakcií | Školská jedáleň';
include 'header.php';
?>
<section class="container">
    <h1>História transakcií</h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Uskutočnené</th>
                <th scope="col">Popis</th>
                <th scope="col">Dátum</th>
                <th scope="col">∆ Kredit</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach (selectTransactions($_SESSION['userId'], $_GET['page']) as $key => $order) {
            ?>
            <tr>
                <td>
                    <?=$order['orderDate']?>
                </td>
                <td>
                    <?=$order['description'] ? nl2br($order['description']) : 'Dobitie kreditu'?>
                </td>
                <td>
                    <?=$order['date'] ?? '—'?>
                </td>
                <td>
                    <?=$order['sum']?>€
                </td>
                <td>
                    <?php
                switch ($order['status']) {
                	case STATUS_OPEN:
                		echo "aktívna";
                		break;
                	case STATUS_USED:
                		echo "vydaná";
                		break;
                	case STATUS_CANCELED:
                		echo "zrušená";
                		break;
                }
                    ?>

                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <nav aria-label="History navigation">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="?page=<?=max([((int) $_GET['page'])-1, 0])?>">Predchádzajúca strana</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="?page=<?=((int) $_GET['page'])+1?>">Nasledujúca strana</a>
            </li>
        </ul>
    </nav>
</section>
<?php
include 'footer.php';
?>