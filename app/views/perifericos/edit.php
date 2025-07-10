<?php
$page_title = "Editar Periférico";
ob_start();
?>

<div class="bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Editar Periférico</h1>

    <form action="/energy-system/perifericos/update" method="POST" class="space-y-4">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($periferico['id']); ?>">

        <div>
            <label for="nome" class="block text-gray-700 text-sm font-bold mb-2">Nome:</label>
            <input type="text" name="nome" id="nome" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($periferico['nome']); ?>" required>
        </div>
        <div>
            <label for="marca" class="block text-gray-700 text-sm font-bold mb-2">Marca:</label>
            <input type="text" name="marca" id="marca" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($periferico['marca']); ?>">
        </div>
        <div>
            <label for="modelo" class="block text-gray-700 text-sm font-bold mb-2">Modelo:</label>
            <input type="text" name="modelo" id="modelo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($periferico['modelo']); ?>">
        </div>
        <div>
            <label for="numero_serie" class="block text-gray-700 text-sm font-bold mb-2">Número de Série:</label>
            <input type="text" name="numero_serie" id="numero_serie" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($periferico['numero_serie']); ?>">
        </div>
        <div>
            <label for="patrimonio" class="block text-gray-700 text-sm font-bold mb-2">Patrimônio:</label>
            <input type="text" name="patrimonio" id="patrimonio" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($periferico['patrimonio']); ?>">
        </div>
        <div>
            <label for="localizacao" class="block text-gray-700 text-sm font-bold mb-2">Localização:</label>
            <input type="text" name="localizacao" id="localizacao" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($periferico['localizacao']); ?>">
        </div>
        <div>
            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
            <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="Em uso" <?php echo ($periferico['status'] == 'Em uso') ? 'selected' : ''; ?>>Em uso</option>
                <option value="Estoque" <?php echo ($periferico['status'] == 'Estoque') ? 'selected' : ''; ?>>Estoque</option>
                <option value="Manutenção" <?php echo ($periferico['status'] == 'Manutenção') ? 'selected' : ''; ?>>Manutenção</option>
                <option value="Descartado" <?php echo ($periferico['status'] == 'Descartado') ? 'selected' : ''; ?>>Descartado</option>
            </select>
        </div>
        <div>
            <label for="observacoes" class="block text-gray-700 text-sm font-bold mb-2">Observações:</label>
            <textarea name="observacoes" id="observacoes" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"><?php echo htmlspecialchars($periferico['observacoes']); ?></textarea>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Atualizar
            </button>
            <a href="/energy-system/perifericos" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Cancelar
            </a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require_once 'app/views/layout/layout.php';
?>