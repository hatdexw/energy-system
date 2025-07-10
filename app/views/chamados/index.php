<?php
$page_title = "Chamados"; // Define o título da página
ob_start(); // Inicia o output buffering

// Captura os parâmetros de busca e filtro para manter na URL
$current_search = $_GET['search'] ?? '';
$current_filter_status = $_GET['filter_status'] ?? '';
$current_filter_prioridade = $_GET['filter_prioridade'] ?? '';
$current_filter_assigned_to = $_GET['filter_assigned_to'] ?? '';

// Constrói a string de query para manter os filtros na paginação
$query_params = http_build_query([
    'search' => $current_search,
    'filter_status' => $current_filter_status,
    'filter_prioridade' => $current_filter_prioridade,
    'filter_assigned_to' => $current_filter_assigned_to,
]);

?>

<div class="bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Chamados</h1>

    <div class="mb-6 flex justify-between items-center">
        <a href="/energy-system/chamados/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
            Abrir Novo Chamado
        </a>
        <form action="/energy-system/chamados" method="GET" class="flex items-center space-x-2">
            <input type="text" name="search" id="search" placeholder="Buscar..." class="shadow appearance-none border border-gray-300 rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($current_search); ?>">
            <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Buscar</button>
        </form>
    </div>

    <form action="/energy-system/chamados" method="GET" class="bg-gray-50 p-4 rounded-lg shadow-sm mb-6 border border-gray-200">
        <input type="hidden" name="search" value="<?php echo htmlspecialchars($current_search); ?>">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="filter_status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                <select name="filter_status" id="filter_status" class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" onchange="this.form.submit()">
                    <option value="" <?php echo ($current_filter_status == '') ? 'selected' : ''; ?>>Todos</option>
                    <option value="Aberto" <?php echo ($current_filter_status == 'Aberto') ? 'selected' : ''; ?>>Aberto</option>
                    <option value="Em Andamento" <?php echo ($current_filter_status == 'Em Andamento') ? 'selected' : ''; ?>>Em Andamento</option>
                    <option value="Resolvido" <?php echo ($current_filter_status == 'Resolvido') ? 'selected' : ''; ?>>Resolvido</option>
                    <option value="Fechado" <?php echo ($current_filter_status == 'Fechado') ? 'selected' : ''; ?>>Fechado</option>
                </select>
            </div>
            <div>
                <label for="filter_prioridade" class="block text-gray-700 text-sm font-bold mb-2">Prioridade:</label>
                <select name="filter_prioridade" id="filter_prioridade" class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" onchange="this.form.submit()">
                    <option value="" <?php echo ($current_filter_prioridade == '') ? 'selected' : ''; ?>>Todas</option>
                    <option value="Baixa" <?php echo ($current_filter_prioridade == 'Baixa') ? 'selected' : ''; ?>>Baixa</option>
                    <option value="Média" <?php echo ($current_filter_prioridade == 'Média') ? 'selected' : ''; ?>>Média</option>
                    <option value="Alta" <?php echo ($current_filter_prioridade == 'Alta') ? 'selected' : ''; ?>>Alta</option>
                    <option value="Urgente" <?php echo ($current_filter_prioridade == 'Urgente') ? 'selected' : ''; ?>>Urgente</option>
                </select>
            </div>
            <div>
                <label for="filter_assigned_to" class="block text-gray-700 text-sm font-bold mb-2">Atribuído a:</label>
                <select name="filter_assigned_to" id="filter_assigned_to" class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" onchange="this.form.submit()">
                    <option value="" <?php echo ($current_filter_assigned_to == '') ? 'selected' : ''; ?>>Todos</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user['id']; ?>" <?php echo ($current_filter_assigned_to == $user['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($user['full_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </form>

    <?php if (empty($chamados)): ?>
        <div class="bg-white p-6 rounded-lg shadow-md text-center text-gray-600 border border-gray-200">
            <p>Nenhum chamado encontrado com os critérios selecionados.</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto bg-white rounded-lg shadow-md border border-gray-200">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Título</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Prioridade</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Responsável</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Data de Abertura</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($chamados as $chamado): ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($chamado['titulo']); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars(substr($chamado['descricao'], 0, 50)) . (strlen($chamado['descricao']) > 50 ? '...' : ''); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    <?php
                                    switch ($chamado['status']) {
                                        case 'Aberto': echo 'bg-blue-100 text-blue-800'; break;
                                        case 'Em Andamento': echo 'bg-yellow-100 text-yellow-800'; break;
                                        case 'Resolvido': echo 'bg-green-100 text-green-800'; break;
                                        case 'Fechado': echo 'bg-gray-100 text-gray-800'; break;
                                        default: echo 'bg-gray-100 text-gray-800'; break;
                                    }
                                    ?>">
                                    <?php echo htmlspecialchars($chamado['status']); ?>
                                </span>
                            </td>
                            <td class="py-2 px-4 whitespace-no-wrap">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    <?php
                                    switch ($chamado['prioridade']) {
                                        case 'Baixa': echo 'bg-gray-100 text-gray-800'; break;
                                        case 'Média': echo 'bg-green-100 text-green-800'; break;
                                        case 'Alta': echo 'bg-yellow-100 text-yellow-800'; break;
                                        case 'Urgente': echo 'bg-red-100 text-red-800'; break;
                                        default: echo 'bg-gray-100 text-gray-800'; break;
                                    }
                                    ?>">
                                    <?php echo htmlspecialchars($chamado['prioridade']); ?>
                                </span>
                            </td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($chamado['assigned_to_full_name'] ?? 'Não Atribuído'); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-700"><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($chamado['created_at']))); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-right text-sm leading-5 font-medium space-x-2">
                                <a href="/energy-system/chamados/edit?id=<?php echo $chamado['id']; ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1.5 px-3 rounded-md text-sm focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Editar</a>
                                <form action="/energy-system/chamados/delete" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este chamado?');">
                                    <input type="hidden" name="id" value="<?php echo $chamado['id']; ?>">
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
                    <a href="/energy-system/chamados?page=<?php echo $page - 1; ?>&<?php echo $query_params; ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Anterior</a>
                <?php endif; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="/energy-system/chamados?page=<?php echo $page + 1; ?>&<?php echo $query_params; ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Próxima</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean(); // Obtém o conteúdo do buffer e limpa o buffer
require_once 'app/views/layout/layout.php'; // Inclui o arquivo de layout
?>