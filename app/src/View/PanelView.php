
<?php
include 'HeaderView.php';
?>

    <div class="container my-5">
        <h1>Confira os nossos produtos!</h1>
        <div class="row">

        <?php foreach ($products as $product): ?>

        <div class="card col-2" style="width: 18rem; padding:0; margin: 5px;">
            <img class="card-img-top" src="https://fakeimg.pl/350x200/?text=<?=$product['produto']?>&font=lobster" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title"><?=$product['produto']?></h5>
                <p class="card-text">
                    <b>$ <?=$product['valor']?></b>
                </p>
                <button class="btn btn-primary" onclick='addToCart(<?= json_encode($product, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'>
                    Adicionar ao carrinho
                </button>
            </div>
        </div>

        <?php endforeach; ?>

        </div>
    </div>

<?php
include 'FooterView.php';