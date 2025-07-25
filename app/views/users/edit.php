<?php

$title = "Editar Usuário";
$page_title = "Editar Usuário";
ob_start();
?>

<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4">Editar Usuário</h2>
    <form action="/energy-system/users/update" method="POST">
        <input type="hidden" name="id" value="<?php echo $user_data['id']; ?>">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Nome de Usuário</label>
<input type="text" name="username" id="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-200 cursor-not-allowed" value="<?php echo $user_data['username']; ?>" disabled>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
            <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-transparent" value="<?php echo $user_data['email']; ?>">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="full_name">Nome Completo</label>
            <input type="text" name="full_name" id="full_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-transparent" value="<?php echo $user_data['full_name']; ?>">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="sector_id">Setor</label>
            <select name="sector_id" id="sector_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                <option value="">None</option>
                <?php foreach ($sectors as $s): ?>
                    <option value="<?php echo $s['id']; ?>" <?php echo ($s['id'] == $user_data['sector_id']) ? 'selected' : ''; ?>><?php echo $s['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="role">Função</label>
            <select name="role" id="role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                <option value="user" <?php echo ($user_data['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                <option value="admin" <?php echo ($user_data['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>
        <div class="flex items-center justify-end">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">Atualizar Usuário</button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require_once 'app/views/layout/layout.php';
?>