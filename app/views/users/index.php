<?php

$title = "Usuários";
$page_title = "Gerenciar Usuários";
ob_start();

// Captura os parâmetros de busca e filtro para manter na URL
$current_search = $_GET['search'] ?? '';
$current_filter_role = $_GET['filter_role'] ?? '';
$current_filter_sector = $_GET['filter_sector'] ?? '';

// Constrói a string de query para manter os filtros na paginação
$query_params = http_build_query([
    'search' => $current_search,
    'filter_role' => $current_filter_role,
    'filter_sector' => $current_filter_sector,
]);

?>

<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4">Usuários Existentes</h2>

    <form action="/energy-system/users" method="GET" class="bg-gray-50 p-4 rounded-lg shadow-sm mb-6 border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label for="search" class="block text-gray-700 text-sm font-bold mb-2">Buscar:</label>
                <input type="text" name="search" id="search" placeholder="Nome, Email, Usuário..." class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($current_search); ?>">
            </div>
            <div>
                <label for="filter_role" class="block text-gray-700 text-sm font-bold mb-2">Função:</label>
                <select name="filter_role" id="filter_role" class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="" <?php echo ($current_filter_role == '') ? 'selected' : ''; ?>>Todas</option>
                    <option value="user" <?php echo ($current_filter_role == 'user') ? 'selected' : ''; ?>>User</option>
                    <option value="admin" <?php echo ($current_filter_role == 'admin') ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>
            <div>
                <label for="filter_sector" class="block text-gray-700 text-sm font-bold mb-2">Setor:</label>
                <select name="filter_sector" id="filter_sector" class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="" <?php echo ($current_filter_sector == '') ? 'selected' : ''; ?>>Todos</option>
                    <?php foreach ($sectors as $s): ?>
                        <option value="<?php echo $s['id']; ?>" <?php echo ($current_filter_sector == $s['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($s['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="md:col-span-3 flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Aplicar Filtros</button>
            </div>
        </div>
    </form>

    <?php if (empty($users)): ?>
        <p class="text-gray-600">Nenhum usuário encontrado com os critérios selecionados.</p>
    <?php else: ?>
        <div class="overflow-x-auto bg-white rounded-lg shadow-md border border-gray-200">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Nome de Usuário</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Nome Completo</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Setor</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Função</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($u['username']); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($u['email']); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($u['full_name']); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($u['sector_name'] ?? 'None'); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($u['role']); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-right text-sm leading-5 font-medium space-x-2">
                                <a href="/energy-system/users/edit?id=<?php echo $u['id']; ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1.5 px-3 rounded-md text-sm focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Editar</a>
                                <form action="/energy-system/users/delete" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                    <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
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
                    <a href="/energy-system/users?page=<?php echo $page - 1; ?>&<?php echo $query_params; ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Anterior</a>
                <?php endif; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="/energy-system/users?page=<?php echo $page + 1; ?>&<?php echo $query_params; ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Próxima</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <h2 class="text-2xl font-bold mb-4 mt-8">Adicionar Novo Usuário</h2>
    <form action="/energy-system/users/create" method="POST" class="mb-8">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Nome de Usuário</label>
            <input type="text" name="username" id="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Senha</label>
            <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
            <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="full_name">Nome Completo</label>
            <input type="text" name="full_name" id="full_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-transparent" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="sector_id">Setor</label>
            <select name="sector_id" id="sector_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                <option value="">None</option>
                <?php foreach ($sectors as $s): ?>
                    <option value="<?php echo $s['id']; ?>"><?php echo $s['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="role">Função</label>
            <select name="role" id="role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Adicionar Usuário</button>
    </form>
</div>

<?php
$content = ob_get_clean();
require_once 'app/views/layout/layout.php';
?>