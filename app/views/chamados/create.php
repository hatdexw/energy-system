<?php
$page_title = "Abrir Novo Chamado"; // Define o título da página
ob_start(); // Inicia o output buffering
?>

<div class="bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Abrir Novo Chamado</h1>

    <form action="/energy-system/chamados/create" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Left Side (Main Content) -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md border border-gray-200">
            <div class="mb-4">
                <label for="titulo" class="block text-gray-700 text-sm font-bold mb-2">Título:</label>
                <input type="text" name="titulo" id="titulo" class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <div class="mb-4">
                <label for="descricao" class="block text-gray-700 text-sm font-bold mb-2">Descrição:</label>
                <textarea name="descricao" id="descricao" rows="10" class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>
            <!-- File Upload (Simplified - no drag and drop or progress bar) -->
            <div class="mb-4">
                <label for="file_upload" class="block text-gray-700 text-sm font-bold mb-2">Anexar Arquivo(s):</label>
                <input type="file" name="file_upload[]" id="file_upload" multiple class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <p class="text-xs text-gray-500 mt-1">Arraste e solte seu arquivo aqui, ou clique para selecionar (40 MB máx)</p>
            </div>
        </div>

        <!-- Right Side (Sidebar/Accordion-like) -->
        <div class="lg:col-span-1 space-y-4 overflow-y-auto max-h-[80vh]">
            <!-- Chamado Details -->
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <h2 class="text-lg font-bold mb-4 text-gray-800">Detalhes do Chamado</h2>
                <div class="mb-4">
                    <label for="data_abertura" class="block text-gray-700 text-sm font-bold mb-2">Data de abertura:</label>
                    <input type="text" name="data_abertura" id="data_abertura" class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo date('d-m-Y H:i:s'); ?>" readonly>
                </div>
                <div class="mb-4">
                    <label for="tipo" class="block text-gray-700 text-sm font-bold mb-2">Tipo:</label>
                    <select name="tipo" id="tipo" class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="Incidente">Incidente</option>
                        <option value="Requisicao">Requisição</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                    <select name="status" id="status" class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="Aberto">Aberto</option>
                        <option value="Em Andamento">Em Andamento</option>
                        <option value="Resolvido">Resolvido</option>
                        <option value="Fechado">Fechado</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="prioridade" class="block text-gray-700 text-sm font-bold mb-2">Prioridade:</label>
                    <select name="prioridade" id="prioridade" class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="Baixa">Baixa</option>
                        <option value="Média">Média</option>
                        <option value="Alta">Alta</option>
                        <option value="Urgente">Urgente</option>
                    </select>
                </div>
            </div>

            <!-- Atores -->
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <h2 class="text-lg font-bold mb-4 text-gray-800">Atores</h2>
                <div class="mb-4">
                    <label for="requerente" class="block text-gray-700 text-sm font-bold mb-2">Requerente:</label>
                    <select name="requerente" id="requerente" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Selecione o Requerente</option>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['full_name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                </div>
                <div class="mb-4">
                    <label for="observador" class="block text-gray-700 text-sm font-bold mb-2">Observador:</label>
                    <select name="observador" id="observador" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Selecione o Observador</option>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['full_name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                </div>
                <div class="mb-4">
                    <label for="user_id" class="block text-gray-700 text-sm font-bold mb-2">Atribuído:</label>
                    <select name="user_id" id="user_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Não Atribuído</option>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['full_name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                </div>
            </div>

            <!-- Itens (Simplified) -->
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <h2 class="text-lg font-bold mb-4 text-gray-800">Itens</h2>
                <div class="mb-4">
                    <label for="meus_perifericos" class="block text-gray-700 text-sm font-bold mb-2">Meus periféricos:</label>
                    <select name="meus_perifericos" id="meus_perifericos" class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">-----</option>
                        <!-- Exemplo: <option value="computador">Computador - EEN-WKS-07</option> -->
                    </select>
                </div>
                <div class="mb-4">
                    <label for="busca_completa" class="block text-gray-700 text-sm font-bold mb-2">Ou busca completa:</label>
                    <select name="busca_completa" id="busca_completa" class="shadow appearance-none border border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Geral</option>
                        <!-- Outras opções de itens -->
                    </select>
                </div>
                <button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center focus:outline-none focus:shadow-outline">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m0-6H6"></path></svg>
                    <span>Adicionar</span>
                </button>
            </div>
        </div>
        <!-- Form Actions -->
        <div class="lg:col-span-3 flex justify-end items-center mt-6 space-x-4">
            <a href="/energy-system/chamados" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Cancelar
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outlo ine">
                Abrir Chamado
            </button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean(); // Obtém o conteúdo do buffer e limpa o buffer
require_once 'app/views/layout/layout.php'; // Inclui o arquivo de layout
?>