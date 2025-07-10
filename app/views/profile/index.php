<?php
$page_title = 'Meu Perfil';
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Meu Perfil</h2>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['success_message']; ?></span>
                <?php unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['error_message']; ?></span>
                <?php unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <div class="flex items-center space-x-6 mb-8">
            <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                <?php if (!empty($user['profile_picture'])): ?>
                    <img src="/energy-system/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Foto de Perfil" class="w-full h-full object-cover">
                <?php else: ?>
                    <svg class="w-20 h-20 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
                    </svg>
                <?php endif; ?>
            </div>
            <div>
                <h3 class="text-2xl font-semibold text-gray-700"><?php echo htmlspecialchars($user['full_name']); ?></h3>
                <p class="text-gray-500"><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
        </div>

        <form action="/energy-system/profile/upload" method="POST" enctype="multipart/form-data">
            <div class="mb-6">
                <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-2">Alterar Foto de Perfil</label>
                <div class="flex items-center">
                    <input type="file" name="profile_picture" id="profile_picture" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>
