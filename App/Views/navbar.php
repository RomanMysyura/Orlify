<div>
    <nav class="bg-black">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-24 items-center justify-between">
                <button class="" aria-label="Logo">
                    <a href="/">
                        <img class="h-20 w-auto sm:h-20" src="/img/logo.png" alt="Logo">
                    </a>
                </button>
            </div>
        </div>
</div>
</nav>
<nav class="bg-white">
    <div class="mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-4">

                        <a href="/contactar"
                            class="text-black hover:bg-gray-300 hover:text-black rounded-md px-3 py-2 text-lg font-medium">Contactar</a>
                        <?php if ($_SERVER['REQUEST_URI'] !== '/'): ?>
                        <a href="/"
                            class="text-black hover:bg-gray-300 hover:text-black rounded-md px-3 py-2 text-lg font-medium">Inici</a>
                        <?php endif; ?>

                    </div>

                </div>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                <div class="relative ml-3">
                    <div>
                        <button type="button" class="flex items-center justify-center" id="user-menu-button"
                            aria-expanded="false" aria-haspopup="true">


                            <?php if (isset($_SESSION["logged"]) && $_SESSION["logged"]): ?>
                            <div class="sm:hidden" id="mobile-menu">
                                <div class="space-y-1 px-2 pb-3 pt-2">
                                    <a href="/contactar"
                                        class="text-black hover:bg-gray-300 hover:text-black rounded-md px-3 py-2 text-lg font-medium">Contactar</a>
                                </div>

                            </div>
                            <?php if ($_SESSION["role"] == "Equip Directiu"): ?>
                            <a href="/panel-de-control"
                                class="text-black hover:bg-gray-300 hover:text-black rounded-md px-3 py-2 text-lg font-medium">Panel
                                de control</a>
                                <?php endif; ?>
                                <?php if ($_SESSION["role"] == "Professor" || $_SESSION["role"] == "Equip Directiu"): ?>
                            <a href="/orles"
                                class="text-black hover:bg-gray-300 hover:text-black rounded-md px-3 py-2 text-lg font-medium">Editor
                                de orles</a>
                            <?php endif; ?>

                            <?php if ($_SESSION["role"] == "Alumne"): ?>
                            <a href="/meves-orles"
                                class="text-black hover:bg-gray-300 hover:text-black rounded-md px-3 py-2 text-lg font-medium">Les meves orles</a>
                            <?php endif; ?>

                            <details class="dropdown dropdown-bottom dropdown-end">
                                <summary
                                    class="flex items-center justify-center text-black hover:bg-gray-300 hover:text-black rounded-md px-3 py-2 text-lg font-medium">
                                    <div class="avatar">
                                        <div class="w-10 rounded-full">
                                            <?php if (!empty($photo)): ?>
                                            <!-- Aplica border-radius al contenedor de la imagen -->
                                            <img src="../<?= $photo[0]['url'] ?>"
                                                class="rounded-full w-full h-full object-cover" alt="Foto" />
                                            <?php else: ?>
                                            <img src="../img/user2.png" alt="Default"/>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </summary>
                                <ul
                                    class="p-2  drop-shadow-lg  shadow menu dropdown-content z-[1] bg-base-100 rounded-box w-52">
                                    <li><a href="/perfil">Editar dades</a></li>
                                    <li><a href="/carnet/<?php $usuari['token'];?>">Carnet</a></li>
                                    <?php if ($_SESSION["role"] == "Professor"): ?>
                                    <li><a href="/alumnes">Els meus alumnes</a></li>
                                    <?php endif;?>
                                    <?php if ($_SESSION["role"] == "Admin"): ?>
                                    <li><a href="/admin">Administrar</a></li>
                                    <?php endif; ?>
                                    <li><a href="/logout" class="text-red">Tancar sessió</a></li>
                                </ul>
                            </details>
                            <?php endif; ?>
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>

</nav>
</div>

<div style="overflow: hidden;">
        <svg id="wave-path" preserveAspectRatio="none" viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg"
            style="fill: #ffffff; width: 100%; height: 60px;">

            <path
                d="M0 0v46.29c47.79 22.2 103.59 32.17 158 28 70.36-5.37 136.33-33.31 206.8-37.5 73.84-4.36 147.54 16.88 218.2 35.26 69.27 18 138.3 24.88 209.4 13.08 36.15-6 69.85-17.84 104.45-29.34C989.49 25 1113-14.29 1200 52.47V0z"
                opacity=".25" />
            <path
                d="M0 0v15.81c13 21.11 27.64 41.05 47.69 56.24C99.41 111.27 165 111 224.58 91.58c31.15-10.15 60.09-26.07 89.67-39.8 40.92-19 84.73-46 130.83-49.67 36.26-2.85 70.9 9.42 98.6 31.56 31.77 25.39 62.32 62 103.63 73 40.44 10.79 81.35-6.69 119.13-24.28s75.16-39 116.92-43.05c59.73-5.85 113.28 22.88 168.9 38.84 30.2 8.66 59 6.17 87.09-7.5 22.43-10.89 48-26.93 60.65-49.24V0z"
                opacity=".5" />
            <path
                d="M0 0v5.63C149.93 59 314.09 71.32 475.83 42.57c43-7.64 84.23-20.12 127.61-26.46 59-8.63 112.48 12.24 165.56 35.4C827.93 77.22 886 95.24 951.2 90c86.53-7 172.46-45.71 248.8-84.81V0z" />
        </svg>
    </div>
