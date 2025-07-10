<?php
$title = "Login";
ob_start();
?>

<div class="min-h-screen flex flex-col items-center justify-start bg-gray-100 pt-2 px-4 sm:px-6 lg:px-8">
    <div class="mb-4">
        <img class="mx-auto h-64 w-auto" src="/energy-system/img/Energy.png" alt="Energy System Logo">
    </div>
    
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow-xl">
        <div class="text-center">
        
        </div>

        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['flash_message']; ?></span>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>

        <form class="mt-8 space-y-6" action="/energy-system/login" method="POST">
            <input type="hidden" name="noAUTO" value="1">
            <input type="hidden" name="redirect" value="">

            <div class="space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Usuário</label>
                    <input id="username" name="username" type="text" autocomplete="username" required
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember_me" type="checkbox"
                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                        Lembrar de mim
                    </label>
                </div>

                <div class="text-sm">
                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Esqueceu a senha?
                    </a>
                </div>
            </div>

            <div>
                <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Entrar
                </button>
            </div>
        </form>

        <div class="text-center text-gray-500 text-xs mt-6">
            &copy;2025 Energy System. Todos os direitos reservados.
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once 'app/views/layout/auth_layout.php';
?>