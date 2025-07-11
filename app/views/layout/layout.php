<?php
require_once 'app/models/Notification.php';

$notificationModel = new Notification();
$logged_in_user_id = $_SESSION['user_id'] ?? null;
$unread_notifications = [];
$notification_count = 0;

if ($logged_in_user_id) {
    $unread_notifications = $notificationModel->getUnreadNotifications($logged_in_user_id);
    $notification_count = count($unread_notifications);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Energy System'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-neutral-100 font-sans flex h-screen">
    <!-- Sidebar Toggle Button (for mobile) -->
    <button id="sidebar-toggle" class="lg:hidden fixed top-4 left-4 z-50 p-2 rounded-md bg-gray-800 text-white focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
    </button>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-72 bg-gray-900 text-white p-4 space-y-6 shadow-2xl fixed inset-y-0 left-0 transform -translate-x-full lg:relative lg:translate-x-0 transition-transform duration-300 ease-in-out z-40">
        <div class="flex items-center justify-center mb-2">
            <img src="/energy-system/img/aside.png" alt="Energy System Logo" class="h-42 w-auto mr-3">
           
        </div>
        <nav class="flex-1">
            <ul class="space-y-2">
                <li><a href="/energy-system/dashboard" class="flex items-center py-2 px-4 rounded-lg text-neutral-200 hover:bg-neutral-700 hover:text-white transition duration-200 ease-in-out group">
                    <svg class="w-5 h-5 mr-3 text-neutral-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Inicio
                </a></li>
                <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'user')): ?>
                    
                    <li><a href="/energy-system/normative_documents" class="flex items-center py-2 px-4 rounded-lg text-neutral-200 hover:bg-neutral-700 hover:text-white transition duration-200 ease-in-out group">
                        <svg class="w-5 h-5 mr-3 text-neutral-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 2v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Documentos Normativos
                    </a></li>
                    <li><a href="/energy-system/chamados?filter_status=Aberto" class="flex items-center py-2 px-4 rounded-lg text-neutral-200 hover:bg-neutral-700 hover:text-white transition duration-200 ease-in-out group">
                        <svg class="w-5 h-5 mr-3 text-neutral-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897m4.905-2.727l.777 2.897m0 4.905l.777 2.897M2.239 7.188l2.897.777m4.905 0l2.897.777M7.188 16.812l.777 2.897M16.812 7.188l2.897.777M16.812 16.812l2.897.777M3 15.25V4.75A2.75 2.75 0 015.75 2h12.5A2.75 2.75 0 0121 4.75v10.5A2.75 2.75 0 0118.25 18H5.75A2.75 2.75 0 013 15.25z"></path></svg>
                        Chamados
                    </a></li>
                    <li><a href="/energy-system/reunioes" class="flex items-center py-2 px-4 rounded-lg text-neutral-200 hover:bg-neutral-700 hover:text-white transition duration-200 ease-in-out group">
                        <svg class="w-5 h-5 mr-3 text-neutral-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 2v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Reuniões
                    </a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <li><a href="/energy-system/perifericos" class="flex items-center py-2 px-4 rounded-lg text-neutral-200 hover:bg-neutral-700 hover:text-white transition duration-200 ease-in-out group">
                        <svg class="w-5 h-5 mr-3 text-neutral-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-2-1m0 0l-2 1m2-1V4a2 2 0 012-2h4a2 2 0 012 2v12m-4 0h4m-4 0l-2 5m2-5l2 5m7.5-3H12M12 10.5V15m0 0l-2 5m2-5l2 5m7.5-3H12"></path></svg>
                        Periféricos
                    </a></li>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    
                    <li><a href="/energy-system/sectors" class="flex items-center py-2 px-4 rounded-lg text-neutral-200 hover:bg-neutral-700 hover:text-white transition duration-200 ease-in-out group">
                        <svg class="w-5 h-5 mr-3 text-neutral-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Setores
                    </a></li>
                    <li><a href="/energy-system/users" class="flex items-center py-2 px-4 rounded-lg text-neutral-200 hover:bg-neutral-700 hover:text-white transition duration-200 ease-in-out group">
                        <svg class="w-5 h-5 mr-3 text-neutral-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H2v-2a3 3 0 015.356-1.857M7 10a6 6 0 100-12 6 6 0 000 12zm-7 0a6 6 0 1112 0 6 6 0 01-12 0zm18 0a6 6 0 100-12 6 6 0 000 12z"></path></svg>
                        Usuarios
                    </a></li>
                <?php endif; ?>
                <li><a href="/energy-system/logout" class="flex items-center py-2 px-4 rounded-lg text-neutral-200 hover:bg-neutral-700 hover:text-white transition duration-200 ease-in-out group">
                    <svg class="w-5 h-5 mr-3 text-neutral-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Sair
                </a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-neutral-50 shadow-sm p-4 flex justify-between items-center border-b border-neutral-200">
            <h1 class="text-2xl font-semibold text-neutral-800"><?php echo $page_title ?? 'Dashboard'; ?></h1>
            <div class="relative flex items-center space-x-4">
                <!-- Notification Icon -->
                <div class="relative">
                    <button id="notification-button" class="p-2 rounded-full text-neutral-700 hover:bg-neutral-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 ease-in-out">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        
                        <?php if ($notification_count > 0): ?>
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full"><?php echo $notification_count; ?></span>
                        <?php endif; ?>
                    </button>
                    <!-- Notification Dropdown -->
                    <div id="notification-menu" class="absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg py-1 z-50 hidden border border-neutral-200">
                        <div class="px-4 py-2 text-sm text-gray-700 font-semibold border-b border-gray-200">Notificações</div>
                        <?php if ($notification_count > 0): ?>
                            <?php foreach ($unread_notifications as $notification): ?>
                                <a href="/energy-system/notifications/mark-as-read?id=<?php echo $notification['id']; ?>" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100">
                                    <?php echo htmlspecialchars($notification['message']); ?>
                                </a>
                            <?php endforeach; ?>
                            <a href="/energy-system/notifications/mark-as-read" class="block px-4 py-2 text-sm text-blue-600 hover:bg-neutral-100 border-t border-gray-200 text-center">Marcar todas como lidas</a>
                        <?php else: ?>
                            <div class="px-4 py-2 text-sm text-gray-500">Nenhuma notificação nova.</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Profile Dropdown Trigger -->
                <button id="profile-menu-button" class="flex items-center space-x-2 text-neutral-700 focus:outline-none p-2 rounded-full hover:bg-neutral-100 transition duration-200 ease-in-out">
                    <span class="hidden sm:inline font-medium text-neutral-700"><?php echo htmlspecialchars($_SESSION['full_name'] ?? 'Guest'); ?></span>
                    <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                        <?php if (!empty($_SESSION['profile_picture'])): ?>
                            <img src="/energy-system/<?php echo htmlspecialchars($_SESSION['profile_picture']); ?>" alt="Foto de Perfil" class="w-full h-full object-cover">
                        <?php else: ?>
                            <svg class="w-8 h-8 text-neutral-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
                            </svg>
                        <?php endif; ?>
                    </div>
                    <svg class="w-4 h-4 text-neutral-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div id="profile-menu" class="absolute right-0 top-full mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden border border-neutral-200">
                    <a href="/energy-system/profile" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100">Meu Perfil</a>
                    <a href="/energy-system/change-password" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100">Trocar Senha</a>
                    <a href="/energy-system/logout" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100">Sair</a>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-neutral-100 p-4">
            <?php echo $content ?? ''; ?>
        </main>
    </div>

    <script>
        const profileMenuButton = document.getElementById('profile-menu-button');
        const profileMenu = document.getElementById('profile-menu');
        const notificationButton = document.getElementById('notification-button');
        const notificationMenu = document.getElementById('notification-menu');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        const navLinks = document.querySelectorAll('nav ul li a');

        // Profile Dropdown Toggle
        if (profileMenuButton) {
            profileMenuButton.addEventListener('click', (event) => {
                event.stopPropagation();
                profileMenu.classList.toggle('hidden');
                notificationMenu.classList.add('hidden'); // Close notification menu if profile menu is opened
            });
        }

        // Notification Dropdown Toggle
        if (notificationButton) {
            notificationButton.addEventListener('click', (event) => {
                event.stopPropagation();
                notificationMenu.classList.toggle('hidden');
                profileMenu.classList.add('hidden'); // Close profile menu if notification menu is opened
            });
        }

        // Close menus if clicked outside
        window.addEventListener('click', (event) => {
            if (profileMenu && !profileMenu.classList.contains('hidden')) {
                if (!profileMenu.contains(event.target) && !profileMenuButton.contains(event.target)) {
                    profileMenu.classList.add('hidden');
                }
            }
            if (notificationMenu && !notificationMenu.classList.contains('hidden')) {
                if (!notificationMenu.contains(event.target) && !notificationButton.contains(event.target)) {
                    notificationMenu.classList.add('hidden');
                }
            }
        });

        // Sidebar Toggle for Mobile
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }

        // Close sidebar if clicked outside on mobile
        window.addEventListener('click', (event) => {
            if (window.innerWidth < 1024 && !sidebar.classList.contains('-translate-x-full')) { // Only on mobile and if sidebar is open
                if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                    sidebar.classList.add('-translate-x-full');
                }
            }
        });

        // Active Link Highlighting
        const currentPath = window.location.pathname;
        navLinks.forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('bg-neutral-700', 'text-white');
                link.classList.remove('text-neutral-200');
            } else if (currentPath.startsWith(link.pathname) && link.pathname !== '/energy-system/') {
                // This handles cases like /energy-system/chamados/create matching /energy-system/chamados
                link.classList.add('bg-neutral-700', 'text-white');
                link.classList.remove('text-neutral-200');
            }
        });

    </script>
</body>
</html>