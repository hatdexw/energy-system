<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($document['title']); ?> - Documento Normativo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa; /* Light gray background */
            color: #343a40; /* Dark gray text */
            line-height: 1.6;
        }
        .document-wrapper {
            display: flex;
            justify-content: center;
            padding: 2rem;
        }
        .document-content {
            background-color: #ffffff;
            width: 21cm; /* A4 width */
            min-height: 29.7cm; /* A4 height */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); /* Softer shadow */
            padding: 2.5cm; /* Generous padding for a clean look */
            box-sizing: border-box;
            position: relative;
        }
        .document-header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start; /* Align items to the top */
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #e9ecef; /* Subtle border */
        }
        .document-header-section .logo-area img {
            height: 120px; /* Increased logo size */
            width: auto;
        }
        .document-header-info {
            text-align: right;
            font-size: 0.9rem;
            color: #343a40;
        }
        .document-header-info p {
            margin: 0;
            line-height: 1.4;
        }
        .document-header-info p strong {
            font-weight: 600;
            color: #212529;
        }
        .document-header-info .doc-type {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #212529;
        }
        .document-title {
            font-size: 2.2rem; /* Larger title */
            font-weight: 700; /* Bolder */
            color: #212529; /* Darker for emphasis */
            text-align: center;
            margin-top: 2rem;
            margin-bottom: 2rem;
            line-height: 1.2;
        }
        .metadata {
            margin-bottom: 2rem;
            font-size: 0.9rem;
            color: #6c757d; /* Muted text for metadata */
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Responsive grid for metadata */
            gap: 0.5rem;
        }
        .metadata p strong {
            color: #495057;
        }
        .content h1, .content h2, .content h3, .content h4, .content h5, .content h6 {
            font-weight: 600;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            color: #212529;
        }
        .content h1 { font-size: 2em; }
        .content h2 { font-size: 1.75em; }
        .content h3 { font-size: 1.5em; }
        .content p {
            margin-bottom: 1rem;
        }
        .footer {
            position: absolute;
            bottom: 2.5cm; /* Align with padding */
            left: 2.5cm;
            right: 2.5cm;
            border-top: 1px solid #e9ecef;
            padding-top: 1rem;
            font-size: 0.75rem;
            color: #6c757d;
            text-align: center;
        }

        /* Print specific styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
                background-color: #fff; /* White background for print */
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .no-print {
                display: none !important;
            }
            .document-wrapper {
                padding: 0;
            }
            .document-content {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                padding: 2.5cm !important; /* Maintain padding for print */
                min-height: auto; /* Let content define height */
            }
            .footer {
                position: relative; /* Reset position for print flow */
                bottom: auto;
                left: auto;
                right: auto;
                margin-top: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="no-print flex justify-end p-4 bg-gray-100 border-b border-gray-200">
        <a href="/energy-system/normative_documents" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2">
            &larr; Voltar
        </a>
        <?php if ($document['created_by'] == $_SESSION['user_id']) : ?>
            <a href="/energy-system/normative_documents/edit?id=<?php echo $document['id']; ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-md text-sm focus:outline-none focus:shadow-outline transition duration-150 ease-in-out mr-2">Editar</a>
            <form action="/energy-system/normative_documents/delete" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este documento?');">
                <input type="hidden" name="id" value="<?php echo $document['id']; ?>">
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-md text-sm focus:outline-none focus:shadow-outline transition duration-150 ease-in-out mr-2">Excluir</button>
            </form>
        <?php endif; ?>
        <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Imprimir
        </button>
    </div>

    <div class="document-wrapper">
        <div class="document-content">
            <div class="document-header-section">
                <div class="logo-area">
                    <img src="/energy-system/img/Energy.png" alt="Logo da Empresa">
                </div>
                <div class="document-header-info">
                    <p class="doc-type">DOCUMENTO NORMATIVO</p>
                    <p>CÓDIGO: <strong><?php echo htmlspecialchars($document['document_number'] ?? 'N/A'); ?></strong></p>
                    <p>VERSÃO: <strong><?php echo htmlspecialchars($document['version'] ?? 'N/A'); ?></strong></p>
                    <p>DATA: <strong><?php echo htmlspecialchars($document['issue_date'] ? date('d/m/Y', strtotime($document['issue_date'])) : 'N/A'); ?></strong></p>
                    <p>UNIDADE: <strong><?php echo htmlspecialchars($document['unidade'] ?? 'N/A'); ?></strong></p>
                    <p>ÁREA: <strong><?php echo htmlspecialchars($document['area'] ?? 'N/A'); ?></strong></p>
                    <p>VALIDADE: <strong><?php echo htmlspecialchars($document['validade'] ? date('d/m/Y', strtotime($document['validade'])) : 'N/A'); ?></strong></p>
                </div>
            </div>

            <h1 class="document-title">
                <?php echo htmlspecialchars($document['title']); ?>
            </h1>

            <div class="metadata">
                <p><strong>Criado por:</strong> <?php echo htmlspecialchars($document['created_by_name']); ?></p>
                <p><strong>Data de Criação:</strong> <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($document['created_at']))); ?></p>
                <p><strong>Última Atualização:</strong> <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($document['updated_at']))); ?></p>
            </div>

            <div class="content">
                <?php echo nl2br(htmlspecialchars($document['content'])); // nl2br para manter quebras de linha ?>
            </div>

            <div class="footer">
                <p>Este é um documento normativo interno da empresa. Proibida a reprodução sem autorização.</p>
                <p>&copy; <?php echo date('Y'); ?> Energy System. Todos os direitos reservados.</p>
            </div>
        </div>
    </div>
</body>
</html>