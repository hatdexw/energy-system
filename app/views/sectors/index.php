<?php

$title = "Setores";
$page_title = "Gerenciar Setores";
ob_start();
?>

<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4">Adicionar Novo Setor</h2>
    <form action="/energy-system/sectors/create" method="POST" class="mb-8">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nome do Setor</label>
            <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-transparent">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Descrição</label>
            <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-transparent"></textarea>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="parent_id">Setor Pai (Opcional)</label>
            <select name="parent_id" id="parent_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                <option value="">None</option>
                <?php foreach ($sectors as $s): ?>
                    <option value="<?php echo $s['id']; ?>"><?php echo $s['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Adicionar Setor</button>
    </form>

    <h2 class="text-2xl font-bold mb-4">Setores Existentes</h2>
    <?php if (empty($sectors)): ?>
        <p class="text-gray-600">Nenhum setor definido ainda.</p>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Pai</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sectors as $s): ?>
                        <tr>
                            <td class="py-2 px-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 font-medium text-gray-900"><?php echo $s['name']; ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-900"><?php echo $s['description']; ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-900">
                                <?php
                                    $parent_name = 'None';
                                    if ($s['parent_id']) {
                                        foreach ($sectors as $parent_s) {
                                            if ($parent_s['id'] == $s['parent_id']) {
                                                $parent_name = $parent_s['name'];
                                                break;
                                            }
                                        }
                                    }
                                    echo $parent_name;
                                ?>
                            </td>
                            <td class="py-2 px-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                                <a href="/energy-system/sectors/edit?id=<?php echo $s['id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-4">Editar</a>
                                <form action="/energy-system/sectors/delete" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este setor?');">
                                    <input type="hidden" name="id" value="<?php echo $s['id']; ?>">
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