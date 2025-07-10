<?php
$page_title = "Periféricos";
ob_start();

// Captura os parâmetros de busca e filtro para manter na URL
$current_search = $_GET['search'] ?? '';
$current_filter_status = $_GET['filter_status'] ?? '';
$current_filter_localizacao = $_GET['filter_localizacao'] ?? '';

// Constrói a string de query para manter os filtros na paginação
$query_params = http_build_query([
    'search' => $current_search,
    'filter_status' => $current_filter_status,
    'filter_localizacao' => $current_filter_localizacao,
]);

// Obter todas as localizações únicas para o filtro
$all_perifericos = $periferico_model->getAll(); // Temporário para pegar todas as localizações
$localizacoes = array_unique(array_column($all_perifericos, 'localizacao'));
sort($localizacoes);

?>

<div class="bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Periféricos</h1>

    <div class="mb-6 flex justify-between items-center">
        <a href="/energy-system/perifericos/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
            Novo Periférico
        </a>
        <form action="/energy-system/perifericos" method="GET" class="flex items-center space-x-2">
            <input type="text" name="search" id="search" placeholder="Buscar..." class="shadow appearance-none border border-gray-300 rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($current_search); ?>">
            <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Buscar</button>
        </form>
    </div>

    <form action="/energy-system/perifericos" method="GET" class="bg-gray-50 p-4 rounded-lg shadow-sm mb-6 border border-gray-200">
        <input type="hidden" name="search" value="<?php echo htmlspecialchars($current_search); ?>">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="filter_status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                <select name="filter_status" id="filter_status" class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" onchange="this.form.submit()">
                    <option value="" <?php echo ($current_filter_status == '') ? 'selected' : ''; ?>>Todos</option>
                    <option value="Ativo" <?php echo ($current_filter_status == 'Ativo') ? 'selected' : ''; ?>>Ativo</option>
                    <option value="Inativo" <?php echo ($current_filter_status == 'Inativo') ? 'selected' : ''; ?>>Inativo</option>
                    <option value="Manutenção" <?php echo ($current_filter_status == 'Manutenção') ? 'selected' : ''; ?>>Manutenção</option>
                    <option value="Descartado" <?php echo ($current_filter_status == 'Descartado') ? 'selected' : ''; ?>>Descartado</option>
                </select>
            </div>
            <div>
                <label for="filter_localizacao" class="block text-gray-700 text-sm font-bold mb-2">Localização:</label>
                <select name="filter_localizacao" id="filter_localizacao" class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" onchange="this.form.submit()">
                    <option value="" <?php echo ($current_filter_localizacao == '') ? 'selected' : ''; ?>>Todas</option>
                    <?php foreach ($localizacoes as $loc): ?>
                        <option value="<?php echo htmlspecialchars($loc); ?>" <?php echo ($current_filter_localizacao == $loc) ? 'selected' : ''; ?>><?php echo htmlspecialchars($loc); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </form>

    <?php if (empty($perifericos)): ?>
        <div class="bg-white p-6 rounded-lg shadow-md text-center text-gray-600 border border-gray-200">
            <p>Nenhum periférico encontrado com os critérios selecionados.</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto bg-white rounded-lg shadow-md border border-gray-200">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Marca / Modelo</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">N/S / Patrimônio</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Localização</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($perifericos as $periferico): ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($periferico['id']); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($periferico['nome']); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($periferico['marca']); ?> / <?php echo htmlspecialchars($periferico['modelo']); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($periferico['numero_serie']); ?> / <?php echo htmlspecialchars($periferico['patrimonio']); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($periferico['localizacao']); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    <?php
                                    switch ($periferico['status']) {
                                        case 'Ativo': echo 'bg-green-100 text-green-800'; break;
                                        case 'Inativo': echo 'bg-red-100 text-red-800'; break;
                                        case 'Manutenção': echo 'bg-yellow-100 text-yellow-800'; break;
                                        case 'Descartado': echo 'bg-gray-100 text-gray-800'; break;
                                        default: echo 'bg-gray-100 text-gray-800'; break;
                                    }
                                    ?>">
                                    <?php echo htmlspecialchars($periferico['status']); ?>
                                </span>
                            </td>
                            <td class="py-2 px-4 whitespace-no-wrap text-right text-sm leading-5 font-medium space-x-2">
                                <a href="/energy-system/perifericos/edit?id=<?php echo $periferico['id']; ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1.5 px-3 rounded-md text-sm focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Editar</a>
                                <form action="/energy-system/perifericos/delete" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este periférico?');">
                                    <input type="hidden" name="id" value="<?php echo $periferico['id']; ?>">
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1.5 px-3 rounded-md text-sm focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-between items-center">
            <div>
                <span class="text-gray-700">Página <?php echo $page; ?> de <?php echo $totalPages; ?></span>
            </div>
            <div class="flex space-x-2">
                <?php if ($page > 1): ?>
                    <a href="/energy-system/perifericos?page=<?php echo $page - 1; ?>&<?php echo $query_params; ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Anterior</a>
                <?php endif; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="/energy-system/perifericos?page=<?php echo $page + 1; ?>&<?php echo $query_params; ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Próxima</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require_once 'app/views/layout/layout.php';
?>