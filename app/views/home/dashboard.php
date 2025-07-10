<?php

$title = "Dashboard";
$page_title = "Inicio";
ob_start();

require_once 'app/models/Chamado.php';
require_once 'app/models/Periferico.php';

$chamadoModel = new Chamado();
$perifericoModel = new Periferico();

$totalChamados = $chamadoModel->countAll();
$chamadosAbertos = $chamadoModel->countByStatus('Aberto'); // Assumindo que 'Aberto' é um status válido
$totalPerifericos = $perifericoModel->countAll();
$recentOpenChamados = $chamadoModel->getRecentOpenChamados();

?>

<div class="container mx-auto p-6 bg-gray-100 min-h-screen">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Bem-vindo, <?php echo htmlspecialchars($_SESSION['full_name'] ?? 'Usuário'); ?>!</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Card 1: Total de Chamados -->
        <a href="/energy-system/chamados" class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between hover:bg-gray-50 transition">
            <div>
                <p class="text-gray-500 text-sm">Total de Chamados</p>
                <h3 class="text-3xl font-bold text-indigo-600"><?php echo $totalChamados; ?></h3>
            </div>
            <div class="p-3 bg-indigo-100 rounded-full">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
        </a>

        <!-- Card 2: Chamados Abertos -->
        <a href="/energy-system/chamados?filter_status=Aberto" class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between hover:bg-gray-50 transition">
            <div>
                <p class="text-gray-500 text-sm">Chamados Abertos</p>
                <h3 class="text-3xl font-bold text-yellow-600"><?php echo $chamadosAbertos; ?></h3>
            </div>
            <div class="p-3 bg-yellow-100 rounded-full">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </a>

        <!-- Card 3: Periféricos Cadastrados -->
        <a href="/energy-system/perifericos" class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between hover:bg-gray-50 transition">
            <div>
                <p class="text-gray-500 text-sm">Periféricos Cadastrados</p>
                <h3 class="text-3xl font-bold text-green-600"><?php echo $totalPerifericos; ?></h3>
            </div>
            <div class="p-3 bg-green-100 rounded-full">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-1.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
        </a>
    </div>

    <!-- Seção de Atividades Recentes -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Últimos Chamados Abertos</h3>
        <ul class="divide-y divide-gray-200">
            <?php if (!empty($recentOpenChamados)): ?>
                <?php foreach ($recentOpenChamados as $chamado): ?>
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            <p class="text-gray-800">Chamado #<?php echo htmlspecialchars($chamado['id']); ?> - <?php echo htmlspecialchars($chamado['titulo']); ?></p>
                            <p class="text-gray-500 text-sm">Aberto por <?php echo htmlspecialchars($chamado['full_name'] ?? 'N/A'); ?> em <?php echo htmlspecialchars(date('d/m/Y', strtotime($chamado['created_at']))); ?></p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            <?php
                            switch ($chamado['prioridade']) {
                                case 'Baixa': echo 'bg-gray-100 text-gray-800'; break;
                                case 'Média': echo 'bg-green-100 text-green-800'; break;
                                case 'Alta': echo 'bg-yellow-100 text-yellow-800'; break;
                                case 'Urgente': echo 'bg-red-100 text-red-800'; break;
                                default: echo 'bg-gray-100 text-gray-800'; break;
                            }
                            ?>">
                            <?php echo htmlspecialchars($chamado['prioridade']); ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="py-3 text-gray-500">Nenhum chamado aberto recentemente.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once 'app/views/layout/layout.php';
?>