<?php

$title = "Usuários";
$page_title = "Gerenciar Usuários";
ob_start();
?>

<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4">Adicionar Novo Usuário</h2>
    <form action="/energy-system/users/create" method="POST" class="mb-8">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Nome de Usuário</label>
<input type="text" name="username" id="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-transparent">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Senha</label>
            <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-transparent">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
            <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-transparent">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="full_name">Nome Completo</label>
            <input type="text" name="full_name" id="full_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-transparent">
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

    <h2 class="text-2xl font-bold mb-4">Usuários Existentes</h2>
    <?php if (empty($users)): ?>
        <p class="text-gray-600">Nenhum usuário definido ainda.</p>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Nome de Usuário</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Nome Completo</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Setor</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Função</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td class="py-2 px-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 font-medium text-gray-900"><?php echo $u['username']; ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-900"><?php echo $u['email']; ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-900"><?php echo $u['full_name']; ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-900">
                                <?php
                                    $sector_name = 'None';
                                    if ($u['sector_id']) {
                                        foreach ($sectors as $s) {
                                            if ($s['id'] == $u['sector_id']) {
                                                $sector_name = $s['name'];
                                                break;
                                            }
                                        }
                                    }
                                    echo $sector_name;
                                ?>
                            </td>
                            <td class="py-2 px-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-900"><?php echo $u['role']; ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                                <a href="/energy-system/users/edit?id=<?php echo $u['id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-4">Editar</a>
                                <form action="/energy-system/users/delete" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                    <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require_once 'app/views/layout/layout.php';
?>