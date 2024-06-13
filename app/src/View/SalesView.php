
<?php
include 'HeaderView.php';
?>

    <div class="container my-5">
        <h1>Vendas</h1>
        
        <?php foreach ($groupedSales as $sale): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="5"><?= htmlspecialchars($sale['sale_info']['sale_name']) ?> (<?= htmlspecialchars($sale['sale_info']['sale_date']) ?>)</th>
                    </tr>
                    <tr>
                        <th>Nome do Produto</th>
                        <th>Preço do Produto</th>
                        <th>Porcentagem de Imposto</th>
                        <th>Valor do Imposto</th>
                        <th>Total com Imposto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sale['products'] as $product): ?>
                    <tr>
                    <td><?= htmlspecialchars($product['product_name']) ?></td>
                    <td>R$ <?= htmlspecialchars(number_format($product['product_price'], 2, ',', '.')) ?></td>
                    <td><?= htmlspecialchars($product['tax_percentage']) ?>%</td>
                    <td>R$ <?= htmlspecialchars(number_format($product['tax_amount'], 2, ',', '.')) ?></td>
                    <td>R$ <?= htmlspecialchars(number_format($product['total_with_tax'], 2, ',', '.')) ?></td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    </div>

<?php
include 'FooterView.php';