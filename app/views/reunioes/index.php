<?php
$page_title = "Reuniões";
ob_start();
?>

<div class="bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Minhas Reuniões</h1>

    <div class="mb-6 flex justify-between items-center">
        <a href="/energy-system/reunioes/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
            Agendar Nova Reunião
        </a>
    </div>

    <?php if (empty($reunioes)) : ?>
        <div class="bg-white p-6 rounded-lg shadow-md text-center text-gray-600 border border-gray-200">
            <p>Nenhuma reunião agendada ou para a qual você foi convidado.</p>
        </div>
    <?php else : ?>
        <div class="overflow-x-auto bg-white rounded-lg shadow-md border border-gray-200">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Título</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Data e Hora</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Criador</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Meu Status</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Status Geral</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reunioes as $reuniao) : ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($reuniao['titulo']); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-700"><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($reuniao['data_hora']))); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($reuniao['criador_nome']); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    <?php
                                    if ($reuniao['criador_id'] == $_SESSION['user_id']) {
                                        echo 'bg-gray-200 text-gray-800';
                                    } else {
                                        switch ($reuniao['status_participante']) {
                                            case 'aceito': echo 'bg-green-100 text-green-800'; break;
                                            case 'recusado': echo 'bg-red-100 text-red-800'; break;
                                            default: echo 'bg-yellow-100 text-yellow-800'; break;
                                        }
                                    }
                                    ?>">
                                    <?php 
                                        if ($reuniao['criador_id'] == $_SESSION['user_id']) {
                                            echo 'Organizador';
                                        } else {
                                            echo htmlspecialchars(ucfirst($reuniao['status_participante']));
                                        } 
                                    ?>
                                </span>
                            </td>
                            <td class="py-2 px-4 whitespace-no-wrap">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    <?php
                                    switch ($reuniao['status']) {
                                        case 'agendada': echo 'bg-blue-100 text-blue-800'; break;
                                        case 'concluida': echo 'bg-green-100 text-green-800'; break;
                                        case 'cancelada': echo 'bg-red-100 text-red-800'; break;
                                    }
                                    ?>">
                                    <?php echo htmlspecialchars(ucfirst($reuniao['status'])); ?>
                                </span>
                            </td>
                            <td class="py-2 px-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                <a href="/energy-system/reunioes/show?id=<?php echo $reuniao['id']; ?>" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-1.5 px-3 rounded-md text-sm focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Ver Detalhes</a>
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