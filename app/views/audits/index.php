<?php

$title = "Reuniões";
$page_title = "Suas Reuniões";
ob_start();
?>

<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4">Adicionar Nova Reunião</h2>
    <form action="/energy-system/audits/create" method="POST" class="mb-8">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Título</label>
            <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-transparent">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Descrição</label>
            <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-transparent"></textarea>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="audit_date">Data da Reunião</label>
            <input type="date" name="audit_date" id="audit_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-transparent">
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Adicionar Reunião</button>
    </form>

    <h2 class="text-2xl font-bold mb-4">Suas Reuniões</h2>
    <?php if (empty($audits)): ?>
        <p class="text-gray-600">Nenhuma reunião ainda.</p>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Título</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Data da Reunião</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Criado Em</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($audits as $audit): ?>
                        <tr>
                            <td class="py-2 px-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 font-medium text-gray-900"><?php echo $audit['title']; ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-900"><?php echo $audit['description']; ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-900"><?php echo $audit['audit_date']; ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-900"><?php echo $audit['created_at']; ?></td>
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