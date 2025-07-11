<?php
$page_title = "Agendar Nova Reunião";
ob_start();
?>

<div class="bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Agendar Nova Reunião</h1>

    <?php if (isset($error)) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Erro!</strong>
            <span class="block sm:inline"><?php echo $error; ?></span>
        </div>
    <?php endif; ?>

    <form action="/energy-system/reunioes/create" method="POST">
        <div class="mb-4">
            <label for="titulo" class="block text-gray-700 text-sm font-bold mb-2">Título:</label>
            <input type="text" name="titulo" id="titulo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="descricao" class="block text-gray-700 text-sm font-bold mb-2">Descrição (Pauta):</label>
            <textarea name="descricao" id="descricao" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>

        <div class="mb-4">
            <label for="data_hora" class="block text-gray-700 text-sm font-bold mb-2">Data e Hora:</label>
            <input type="datetime-local" name="data_hora" id="data_hora" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="search_available_users" class="block text-gray-700 text-sm font-bold mb-2">Buscar Usuários:</label>
            <input type="text" id="search_available_users" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" placeholder="Digite para buscar...">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Usuários Disponíveis:</label>
                    <div id="available_users" class="border rounded w-full p-2 h-64 overflow-y-auto bg-gray-50">
                        <?php foreach ($users as $user) : ?>
                            <?php if ($user['id'] != $_SESSION['user_id']) : // Não listar o próprio criador ?>
                                <div class="user-item p-2 hover:bg-gray-200 cursor-pointer border-b last:border-b-0" data-id="<?php echo $user['id']; ?>" data-name="<?php echo htmlspecialchars($user['full_name']); ?>">
                                    <?php echo htmlspecialchars($user['full_name']); ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Participantes Selecionados:</label>
                    <div id="selected_users" class="border rounded w-full p-2 h-64 overflow-y-auto bg-blue-50">
                        <!-- Participantes selecionados serão adicionados aqui via JS -->
                    </div>
                </div>
            </div>
            <input type="hidden" name="participantes[]" id="participantes_hidden_input">
        </div>

        <div class="flex items-center justify-end mt-6">
            <a href="/energy-system/reunioes" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2">
                Cancelar
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Agendar Reunião
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search_available_users');
        const availableUsersDiv = document.getElementById('available_users');
        const selectedUsersDiv = document.getElementById('selected_users');
        const participantesHiddenInput = document.getElementById('participantes_hidden_input');

        // Store all available user items initially
        const allAvailableUserItems = Array.from(availableUsersDiv.children);

        function updateHiddenInput() {
            const selectedIds = Array.from(selectedUsersDiv.children).map(item => item.dataset.id);
            // Clear previous hidden inputs if any (for multiple inputs with same name)
            const existingHiddenInputs = document.querySelectorAll('input[name="participantes[]"]');
            existingHiddenInputs.forEach(input => input.remove());

            // Create new hidden inputs for each selected participant
            selectedIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'participantes[]';
                input.value = id;
                participantesHiddenInput.parentNode.insertBefore(input, participantesHiddenInput.nextSibling);
            });
        }

        function filterAvailableUsers() {
            const searchTerm = searchInput.value.toLowerCase();
            availableUsersDiv.innerHTML = ''; // Clear current available users

            allAvailableUserItems.forEach(item => {
                const userName = item.dataset.name.toLowerCase();
                const userId = item.dataset.id;
                // Only add back if it matches search term AND is not already in selected list
                if (userName.includes(searchTerm) && !selectedUsersDiv.querySelector(`[data-id="${userId}"]`)) {
                    availableUsersDiv.appendChild(item);
                }
            });
        }

        // Initial filter to ensure no selected users are in available list on load
        filterAvailableUsers();

        searchInput.addEventListener('keyup', filterAvailableUsers);

        availableUsersDiv.addEventListener('click', function(event) {
            const clickedItem = event.target.closest('.user-item');
            if (clickedItem) {
                selectedUsersDiv.appendChild(clickedItem);
                updateHiddenInput();
                filterAvailableUsers(); // Re-filter available users after moving
            }
        });

        selectedUsersDiv.addEventListener('click', function(event) {
            const clickedItem = event.target.closest('.user-item');
            if (clickedItem) {
                availableUsersDiv.appendChild(clickedItem);
                updateHiddenInput();
                filterAvailableUsers(); // Re-filter available users after moving
            }
        });

        // Ensure hidden input is updated on form submission
        const form = document.querySelector('form');
        form.addEventListener('submit', function() {
            updateHiddenInput();
        });
    });
</script>

<?php
$content = ob_get_clean();
require_once 'app/views/layout/layout.php';
?>