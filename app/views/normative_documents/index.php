<?php
$page_title = "Documentos Normativos";
ob_start();

$approvedDocuments = [];
$pendingDocuments = [];

if (!empty($documents)) {
    foreach ($documents as $document) {
        if ($document['status'] === 'Aprovado') {
            $approvedDocuments[] = $document;
        } else {
            $pendingDocuments[] = $document;
        }
    }
}
?>

<div class="bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Documentos Normativos</h1>

    <div class="mb-6 flex justify-between items-center">
        <a href="/energy-system/normative_documents/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
            Criar Novo Documento
        </a>
    </div>

    <?php if (!empty($pendingDocuments)) : ?>
        <h2 class="text-xl font-bold mb-3 text-gray-700">Documentos para Aprovação</h2>
        <div class="overflow-x-auto bg-white rounded-lg shadow-md border border-gray-200 mb-8">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Código do Documento</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Título</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Unidade</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Área</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Validade</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pendingDocuments as $document) : ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($document['document_number'] ?? 'N/A'); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($document['title']); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($document['unidade'] ?? 'N/A'); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($document['area'] ?? 'N/A'); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-700"><?php echo htmlspecialchars($document['validade'] ? date('d/m/Y', strtotime($document['validade'])) : 'N/A'); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    <?php echo htmlspecialchars($document['status']); ?>
                                </span>
                            </td>
                            <td class="py-2 px-4 whitespace-no-wrap text-right text-xs leading-5 font-medium space-x-1">
                                <a href="/energy-system/normative_documents/show?id=<?php echo $document['id']; ?>" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-1.5 px-3 rounded-md text-sm focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Ver</a>
                                <?php if ($document['created_by'] == $_SESSION['user_id'] || (isset($_SESSION['role']) && $_SESSION['role'] === 'admin')) : ?>
                                    <a href="/energy-system/normative_documents/edit?id=<?php echo $document['id']; ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1.5 px-3 rounded-md text-sm focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Editar</a>
                                    <form action="/energy-system/normative_documents/delete" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este documento?');">
                                        <input type="hidden" name="id" value="<?php echo $document['id']; ?>">
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1.5 px-3 rounded-md text-sm focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Excluir</button>
                                    </form>
                                <?php endif; ?>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                                    <form action="/energy-system/normative_documents/updateStatus" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja APROVAR este documento?');">
                                        <input type="hidden" name="id" value="<?php echo $document['id']; ?>">
                                        <input type="hidden" name="status" value="Aprovado">
                                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1.5 px-3 rounded-md text-sm focus:outline-none focus:shadow-outline transition duration-150 ease-in-out"><i class="fas fa-check"></i> Aprovar</button>
                                    </form>
                                    <form action="/energy-system/normative_documents/updateStatus" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja REJEITAR este documento?');">
                                        <input type="hidden" name="id" value="<?php echo $document['id']; ?>">
                                        <input type="hidden" name="status" value="Obsoleto">
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1.5 px-3 rounded-md text-sm focus:outline-none focus:shadow-outline transition duration-150 ease-in-out"><i class="fas fa-times"></i> Rejeitar</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <?php if (!empty($approvedDocuments)) : ?>
        <h2 class="text-xl font-bold mb-3 text-gray-700">Documentos Aprovados</h2>
        <div class="overflow-x-auto bg-white rounded-lg shadow-md border border-gray-200">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Código do Documento</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Título</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Unidade</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Área</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Validade</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($approvedDocuments as $document) : ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($document['document_number'] ?? 'N/A'); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($document['title']); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($document['unidade'] ?? 'N/A'); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-900"><?php echo htmlspecialchars($document['area'] ?? 'N/A'); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap text-gray-700"><?php echo htmlspecialchars($document['validade'] ? date('d/m/Y', strtotime($document['validade'])) : 'N/A'); ?></td>
                            <td class="py-2 px-4 whitespace-no-wrap">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <?php echo htmlspecialchars($document['status']); ?>
                                </span>
                            </td>
                            <td class="py-2 px-4 whitespace-no-wrap text-right text-sm leading-5 font-medium space-x-2">
                                <a href="/energy-system/normative_documents/show?id=<?php echo $document['id']; ?>" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-1.5 px-3 rounded-md text-sm focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Ver</a>
                                <?php if ($document['created_by'] == $_SESSION['user_id'] || (isset($_SESSION['role']) && $_SESSION['role'] === 'admin')) : ?>
                                    <form action="/energy-system/normative_documents/delete" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este documento?');">
                                        <input type="hidden" name="id" value="<?php echo $document['id']; ?>">
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1.5 px-3 rounded-md text-sm focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Excluir</button>
                                    </form>
                                <?php endif; ?>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                                    
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <?php if (empty($pendingDocuments) && empty($approvedDocuments)) : ?>
        <div class="bg-white p-6 rounded-lg shadow-md text-center text-gray-600 border border-gray-200">
            <p>Nenhum documento normativo encontrado.</p>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require_once 'app/views/layout/layout.php';
?>