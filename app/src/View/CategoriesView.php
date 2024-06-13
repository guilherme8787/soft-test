
<?php
include 'HeaderView.php';
?>

    <div class="container my-5">
        <h1>Tipos de produtos</h1>
        <button class="btn btn-sm btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#newProductType">Novo</button>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Porcentagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productTypes as $types): ?>
                    <tr>
                        <td><?= htmlspecialchars($types['id']) ?></td>
                        <td><?= htmlspecialchars($types['name']) ?></td>
                        <td><?= htmlspecialchars(number_format($types['percentage'], 2)) ?></td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="editProduct(<?= $types['id'] ?>)">Editar</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteProduct(<?= $types['id'] ?>)">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="newProductType" tabindex="-1" aria-labelledby="newProductModalLabel" aria-hidden="true">
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
                            <label for="productPercentage" class="form-label">Porcentagem</label>
                            <input type="number" class="form-control" id="productPercentage" step="0.01">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="saveNewProductType()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editProductType" tabindex="-1" aria-labelledby="editProductTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductTypeModalLabel">Editar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm">
                        <input type="hidden" id="editProductId">
                        <div class="mb-3">
                            <label for="editProductTypeName" class="form-label">Nome do Produto</label>
                            <input type="text" class="form-control" id="editProductTypeName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductTypePercentage" class="form-label">Porcentagem</label>
                            <input type="number" class="form-control" id="editProductTypePercentage" step="0.01" required>
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

        function saveNewProductType() {
            var data = {
                name: document.getElementById("productName").value,
                percentage: document.getElementById("productPercentage").value,
            };

            fetch("/categories/save", {
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
            const product = <?= json_encode($productTypes); ?>.find(p => p.id == id);

            document.getElementById('editProductId').value = product.id;
            document.getElementById('editProductTypeName').value = product.name;
            document.getElementById('editProductTypePercentage').value = product.percentage;

            var modal = new bootstrap.Modal(document.getElementById('editProductType'));
            modal.show();
        }

        function updateProduct() {
            var data = {
                id: document.getElementById('editProductId').value,
                name: document.getElementById('editProductTypeName').value,
                percentage: document.getElementById('editProductTypePercentage').value
            };

            fetch("/categories/update", {
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
            fetch("/categories/delete", {
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