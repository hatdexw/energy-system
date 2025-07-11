<?php
$page_title = "Detalhes da Reunião";
ob_start();

$user_id = $_SESSION['user_id'];
$is_creator = ($reuniao['criador_id'] == $user_id);

$user_participant_info = null;
foreach ($participantes as $p) {
    if ($p['id'] == $user_id) {
        $user_participant_info = $p;
        break;
    }
}
?>

<div class="bg-white shadow-md rounded-lg p-6">

    <!-- Cabeçalho -->
    <div class="flex justify-between items-start mb-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800"><?php echo htmlspecialchars($reuniao['titulo']); ?></h1>
            <p class="text-sm text-gray-500">Agendada por: <?php echo htmlspecialchars($reuniao['criador_nome']); ?></p>
            <p class="text-sm text-gray-500">Data: <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($reuniao['data_hora']))); ?></p>
        </div>
        <span class="px-3 py-1 rounded-full text-sm font-semibold
            <?php
            switch ($reuniao['status']) {
                case 'agendada': echo 'bg-blue-100 text-blue-800'; break;
                case 'concluida': echo 'bg-green-100 text-green-800'; break;
                case 'cancelada': echo 'bg-red-100 text-red-800'; break;
            }
            ?>">
            <?php echo htmlspecialchars(ucfirst($reuniao['status'])); ?>
        </span>
    </div>

    <!-- Descrição -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-2">Pauta da Reunião</h2>
        <p class="text-gray-600 whitespace-pre-wrap"><?php echo htmlspecialchars($reuniao['descricao']); ?></p>
    </div>

    <!-- Ações do Usuário -->
    <?php if (!$is_creator && $user_participant_info && $reuniao['status'] == 'agendada') : ?>
        <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-6 border border-gray-200">
            <h2 class="text-lg font-bold mb-2 text-gray-800">Você vai participar?</h2>
            <?php if ($user_participant_info['status'] == 'pendente') : ?>
                <form action="/energy-system/reunioes/respond" method="POST" class="flex items-center space-x-4">
                    <input type="hidden" name="id" value="<?php echo $reuniao['id']; ?>">
                    <button type="submit" name="status" value="aceito" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Sim</button>
                    <button type="button" onclick="document.getElementById('recusar-form').style.display='block'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Não</button>
                </form>
                <form action="/energy-system/reunioes/respond" method="POST" id="recusar-form" class="mt-4" style="display:none;">
                    <input type="hidden" name="id" value="<?php echo $reuniao['id']; ?>">
                    <input type="hidden" name="status" value="recusado">
                    <label for="motivo" class="block text-gray-700 text-sm font-bold mb-2">Motivo da recusa (obrigatório):</label>
                    <textarea name="motivo" id="motivo" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mt-2">Enviar Recusa</button>
                </form>
            <?php else : ?>
                <p class="text-gray-700">Sua resposta: <span class="font-bold"><?php echo ucfirst($user_participant_info['status']); ?></span></p>
                <?php if ($user_participant_info['status'] == 'recusado') : ?>
                    <p class="text-gray-600 mt-1"><b>Motivo:</b> <?php echo htmlspecialchars($user_participant_info['motivo_recusa']); ?></p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Lista de Participantes -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-2">Participantes</h2>
        <ul class="space-y-2">
            <?php foreach ($participantes as $participante) : ?>
                <li class="flex items-center justify-between p-2 bg-gray-50 rounded-md">
                    <span class="text-gray-800"><?php echo htmlspecialchars($participante['full_name']); ?></span>
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                        <?php
                        switch ($participante['status']) {
                            case 'aceito': echo 'bg-green-100 text-green-800'; break;
                            case 'recusado': echo 'bg-red-100 text-red-800'; break;
                            default: echo 'bg-yellow-100 text-yellow-800'; break;
                        }
                        ?>">
                        <?php echo htmlspecialchars(ucfirst($participante['status'])); ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Ações do Criador -->
    <?php if ($is_creator && $reuniao['status'] == 'agendada') : ?>
        <div class="flex items-center justify-end space-x-4 mt-6 border-t pt-4">
            <form action="/energy-system/reunioes/updateStatus" method="POST" onsubmit="return confirm('Tem certeza que deseja marcar esta reunião como concluída?');">
                <input type="hidden" name="id" value="<?php echo $reuniao['id']; ?>">
                <input type="hidden" name="status" value="concluida">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Concluir Reunião</button>
            </form>
            <form action="/energy-system/reunioes/delete" method="POST" onsubmit="return confirm('Tem certeza que deseja cancelar esta reunião? Esta ação não pode ser desfeita.');">
                 <input type="hidden" name="id" value="<?php echo $reuniao['id']; ?>">
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Cancelar Reunião</button>
            </form>
        </div>
    <?php endif; ?>

    <div class="mt-6 border-t pt-4">
        <a href="/energy-system/reunioes" class="text-blue-500 hover:text-blue-700">&larr; Voltar para a lista de reuniões</a>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once 'app/views/layout/layout.php';
?>