<?php 
defined('CONTROL') or die('Acesso negado');

$api = new ApiConsumer();

// Verifica se há uma pesquisa
$searchResults = [];
if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
    $searchQuery = htmlspecialchars($_GET['search_query']);
    $searchResults = $api->api($searchQuery)['results'] ?? [];
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center">Buscar Produtos no Mercado Livre</h2>
            <form method="get" action="">
                <div class="input-group mb-3">
                    <input 
                        type="text" 
                        name="search_query" 
                        class="form-control" 
                        placeholder="Digite o que deseja buscar..." 
                        value="<?= htmlspecialchars($_GET['search_query'] ?? '') ?>" 
                        required
                    >
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </div>
            </form>
        </div>
    </div>

    <?php if (!empty($searchResults)): ?>
        <div class="row mt-4">
            <div class="col-md-12">
                <h3>Resultados da Busca:</h3>
                <ul class="list-group">
                    <?php foreach ($searchResults as $result): ?>
                        <li class="list-group-item">
                            <strong><?= htmlspecialchars($result['title']) ?></strong>
                            <br>
                            <span>Preço: R$ <?= number_format($result['price'], 2, ',', '.') ?></span>
                            <br>
                            <a href="<?= htmlspecialchars($result['permalink']) ?>" target="_blank" class="btn btn-sm btn-info mt-2">Ver Produto</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php elseif (isset($_GET['search_query'])): ?>
        <div class="row mt-4">
            <div class="col-md-12">
                <p class="alert alert-warning">Nenhum resultado encontrado para "<strong><?= htmlspecialchars($_GET['search_query']) ?></strong>".</p>
            </div>
        </div>
    <?php endif; ?>
</div>
