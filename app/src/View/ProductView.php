
<?php
include 'HeaderView.php';
?>

    <div class="container my-5">
        <h1>Produtos</h1>
        <button class="btn btn-sm btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#newProductModal">Novo</button>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Tipo de Produto</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['id']) ?></td>
                        <td><?= htmlspecialchars($product['produto']) ?></td>
                        <td><?= htmlspecialchars(number_format($product['valor'], 2)) ?></td>
                        <td><?= htmlspecialchars($product['tipo']) ?></td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="editProduct(<?= $product['id'] ?>)">Editar</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteProduct(<?= $product['id'] ?>)">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="newProductModal" tabindex="-1" aria-labelledby="newProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newProductModalLabel">Adicionar Novo Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newProductForm">
                        <div class="mb-3">
                            <label for="productName" class="form-label">Nome do Produto</label>
                            <input type="text" class="form-control" id="productName">
                        </div>
                        <div class="mb-3">
                            <label for="productPrice" class="form-label">Preço</label>
                            <input type="number" class="form-control" id="productPrice" step="0.01">
                        </div>
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Tipo</label>
                            <select id="productType" class="form-control">
                                <?php foreach ($productTypes as $types): ?>
                                    <option value="<?= htmlspecialchars($types['name']) ?>"><?= htmlspecialchars($types['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="saveNewProduct()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Editar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm">
                        <input type="hidden" id="editProductId">
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Nome do Produto</label>
                            <input type="text" class="form-control" id="editProductName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductPrice" class="form-label">Preço</label>
                            <input type="number" class="form-control" id="editProductPrice" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Tipo</label>
                            <select id="editProductType" class="form-control">
                                <?php foreach ($productTypes as $types): ?>
                                    <option value="<?= htmlspecialchars($types['name']) ?>"><?= htmlspecialchars($types['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="updateProduct()">Salvar Alterações</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const taxRates = JSON.parse('<?=json_encode($productTypes)?>') || [];

        function typeIdByName(name) {
            const item = taxRates.find(item => item.name === name);
            return item ? item.id : null;
        }

        function saveNewProduct() {
            var data = {
                name: document.getElementById("productName").value,
                price: document.getElementById("productPrice").value,
                product_type: document.getElementById("productType").value,
            };

            fetch("/product/save", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(data),
                })
                .then((response) => response.json())
                .then((data) => {
                    alert('Cadastrado com sucesso');
                    window.location.reload();
                })
                .catch((error) => {
                    alert('Erro ao tentar cadastrar');
                });
        }

        function editProduct(id) {
            const product = <?= json_encode($products); ?>.find(p => p.id == id);

            document.getElementById('editProductId').value = product.id;
            document.getElementById('editProductName').value = product.produto;
            document.getElementById('editProductPrice').value = product.valor;
            document.getElementById('editProductType').value = product.tipo;

            var modal = new bootstrap.Modal(document.getElementById('editProductModal'));
            modal.show();
        }

        function updateProduct() {
            let typeId = typeIdByName(
                document.getElementById('editProductType').value
            );

            if (! typeId) {
                return;
            }

            var data = {
                id: document.getElementById('editProductId').value,
                name: document.getElementById('editProductName').value,
                price: document.getElementById('editProductPrice').value,
                product_type: typeId
            };

            fetch("/product/update", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(data),
                })
                .then((response) => response.json())
                .then((data) => {
                    alert('Atualizado com sucesso');
                    window.location.reload();
                })
                .catch((error) => {
                    alert('Erro ao tentar atualizar');
                });
        }

        function deleteProduct(productId) {
            fetch("/product/delete", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        id: productId
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    alert('Deletado com sucesso');
                    window.location.reload();
                })
                .catch((error) => {
                    alert('Erro ao tentar deletar');
                });
        }
    </script>
<?php
include 'FooterView.php';