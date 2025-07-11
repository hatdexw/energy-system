<?php
$page_title = "Criar Documento Normativo";
ob_start();
?>

<div class="bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Criar Novo Documento Normativo</h1>

    <?php if (isset($error)) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Erro!</strong>
            <span class="block sm:inline"><?php echo $error; ?></span>
        </div>
    <?php endif; ?>

    <form action="/energy-system/normative_documents/create" method="POST">
        <div class="mb-4">
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Título:</label>
            <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label for="document_number" class="block text-gray-700 text-sm font-bold mb-2">Código do Documento:</label>
                <input type="text" name="document_number" id="document_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div>
                <label for="issue_date" class="block text-gray-700 text-sm font-bold mb-2">Data de Emissão:</label>
                <input type="date" name="issue_date" id="issue_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div>
                <label for="version" class="block text-gray-700 text-sm font-bold mb-2">Versão:</label>
                <input type="text" name="version" id="version" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            
            <div>
                <label for="area" class="block text-gray-700 text-sm font-bold mb-2">Área:</label>
                <select name="area" id="area" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Selecione a Área</option>
                    <?php foreach ($sectors as $sector): ?>
                        <option value="<?php echo htmlspecialchars($sector['name']); ?>"><?php echo htmlspecialchars($sector['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="validade" class="block text-gray-700 text-sm font-bold mb-2">Validade:</label>
                <input type="date" name="validade" id="validade" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
        </div>

        <div class="mb-4">
            <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Conteúdo:</label>
            <textarea name="content" id="content" rows="15" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>

        <div class="flex items-center justify-end mt-6">
            <a href="/energy-system/normative_documents" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2">
                Cancelar
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Salvar Documento
            </button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require_once 'app/views/layout/layout.php';
?>