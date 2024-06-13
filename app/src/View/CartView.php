
<?php
include 'HeaderView.php';
?>

    <div class="container my-5">
        <h1>Carrinho</h1>
        <br>
        <div id="cart-render">

        </div>

        <div class="d-flex justify-content-end">
            <button id="finalizeButton" class="btn btn-xl btn-primary">Finalizar</button>
        </div>
    </div>

    <script>

        document.getElementById('finalizeButton').addEventListener('click', function() {
            fetch('/cart/finish', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(cartSummary)
            })
            .then(response => response.json())
            .then(data => {
                localStorage.removeItem('cart');
                alert('Venda realizada com sucesso!');
                window.location.href = '/';
            })
            .catch((error) => {
                alert('Error:', error);
            });
        });

        const cart = JSON.parse(localStorage.getItem('cart')) || [];

        const taxRates = JSON.parse('<?=json_encode($productTypes)?>') || [];

        function calculateCartTotals(cart, taxRates) {
            const summary = {
                total: 0,
                totalTax: 0,
                items: []
            };

            const taxes = taxRates.reduce((val, item) => {
                val[item.name] = parseFloat(item.percentage);
                return val;
            }, {});

            const groupedItems = cart.reduce((val, item) => {
                if (!val[item.id]) {
                    val[item.id] = {...item, quantidade: 0, total: 0, tax: 0};
                }
                val[item.id].quantidade += 1;
                val[item.id].total += parseFloat(item.valor);
                val[item.id].tax += parseFloat(item.valor) * (taxes[item.tipo] / 100);
                return val;
            }, {});

            Object.values(groupedItems).forEach(item => {
                summary.total += item.total;
                summary.totalTax += item.tax;
                summary.items.push({
                    id: item.id,
                    produto: item.produto,
                    quantidade: item.quantidade,
                    total: item.total.toFixed(2),
                    tax: item.tax.toFixed(2)
                });
            });

            summary.total = summary.total.toFixed(2);
            summary.totalTax = summary.totalTax.toFixed(2);

            return summary;
        }

        const cartSummary = calculateCartTotals(cart, taxRates);

        function convertToReal(value)
        {
            return parseFloat(value).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
        }

        function generateCartHTML(cartSummary) {
            let html = `<table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Total do Item</th>
                        <th>Imposto</th>
                        <th>Total</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>`;

            cartSummary.items.forEach(item => {
                html += `<tr>
                    <td>${item.produto}</td>
                    <td>${item.quantidade}</td>
                    <td>${convertToReal(item.total)}</td>
                    <td>${convertToReal(item.tax)}</td>
                    <td>${convertToReal(parseFloat(item.total) + parseFloat(item.tax))}</td>
                    <td>
                        <button class="btn btn-warning" onclick="incrementItem('${item.id}')">+</button>
                        <button class="btn btn-success" onclick="decrementItem('${item.id}')">-</button>
                    </td>
                </tr>`;
            });

            html += `</tbody>
                <tfoot>
                    <tr>
                        <th colspan="2">Total</th>
                        <td>${ convertToReal(cartSummary.total) }</td>
                        <td>${ convertToReal(cartSummary.totalTax) }</td>
                        <td>${ convertToReal(parseFloat(cartSummary.total) + parseFloat(cartSummary.totalTax)) }</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>`;

            document.getElementById('cart-render').innerHTML = html;
        }

        function incrementItem(id) {
            const item = cartSummary.items.find(item => item.id == id);
            if (item) {
                item.quantidade++;
                updateItem(item);
            }
            duplicateItemById(id);
            generateCartHTML(cartSummary);
        }

        function decrementItem(id) {
            const item = cartSummary.items.find(item => item.id == id);
            if (item && item.quantidade > 1) {
                item.quantidade--;
            } else if (item && item.quantidade === 1) {
                const index = cartSummary.items.indexOf(item);
                cartSummary.items.splice(index, 1);
            }
            removeItemById(id);
            updateTotals(cartSummary);
            generateCartHTML(cartSummary);
        }

        function updateItem(item) {
            const basePrice = parseFloat(item.total) / (item.quantidade - 1);
            item.total = (basePrice * item.quantidade).toFixed(2);
            const baseTax = parseFloat(item.tax) / (item.quantidade - 1);
            item.tax = (baseTax * item.quantidade).toFixed(2);
            updateTotals(cartSummary);
        }

        function updateTotals(cartSummary) {
            cartSummary.total = cartSummary.items.reduce((sum, item) => sum + parseFloat(item.total), 0).toFixed(2);
            cartSummary.totalTax = cartSummary.items.reduce((sum, item) => sum + parseFloat(item.tax), 0).toFixed(2);
        }

        function removeItemById(id) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const index = cart.findIndex(item => item.id == id);
            if (index !== -1) {
                cart.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(cart));
            }
        }

        function duplicateItemById(itemId) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const item = cart.find(item => item.id == itemId);

            if (item) {
                const newItem = { ...item };
                cart.push(newItem);
                localStorage.setItem('cart', JSON.stringify(cart));
            }
        }

        generateCartHTML(cartSummary);
    </script>

<?php
include 'FooterView.php';