<?php

$title = "Documentos";
$page_title = "Seus Documentos";
ob_start();
?>

<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4">Carregar Novo Documento</h2>
    <form action="/energy-system/documents/upload" method="POST" enctype="multipart/form-data" class="mb-8">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="document">Selecionar Documento</label>
            <input type="file" name="document" id="document" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Carregar Documento</button>
    </form>

    <h2 class="text-2xl font-bold mb-4">Documentos Carregados</h2>
    <?php if (empty($documents)): ?>
        <p class="text-gray-600">Nenhum documento carregado ainda.</p>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Nome do Arquivo</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Carregado Em</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($documents as $doc): ?>
                        <tr>
                            <td class="py-2 px-4 whitespace-no-wrap border-b border-gray-200">
                                <a href="/energy-system/<?php echo $doc['filepath']; ?>" target="_blank" class="text-blue-500 hover:underline">
                                    <?php echo $doc['filename']; ?>
                                </a>
                            </td>
                            <td class="py-2 px-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-900">
                                <?php echo $doc['uploaded_at']; ?>
                            </td>
                            <td class="py-2 px-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                                <!-- Add actions like delete or view details here -->
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