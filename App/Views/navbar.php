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
    <a href="/" class="text-black hover:bg-gray-300 hover:text-black rounded-md px-3 py-2 text-lg font-medium">Inici</a>
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
                                <?php if ($_SERVER['REQUEST_URI'] !== '/'): ?>
    <a href="/" class="text-black hover:bg-gray-300 hover:text-black rounded-md px-3 py-2 text-lg font-medium">Inici</a>
<?php endif; ?>

                            </div>
                            <a href="/panel-de-control"
                                class="text-black hover:bg-gray-300 hover:text-black rounded-md px-3 py-2 text-lg font-medium">Panel
                                de control</a>
                            <a href="/orles"
                                class="text-black hover:bg-gray-300 hover:text-black rounded-md px-3 py-2 text-lg font-medium">Les
                                meves orles</a>

                            <details class="dropdown dropdown-bottom dropdown-end">
                                <summary
                                    class="flex items-center justify-center text-black hover:bg-gray-300 hover:text-black rounded-md px-3 py-2 text-lg font-medium">
                                    <div class="avatar">
                                        <div class="w-10 rounded-full">
                                            <img src="<?= $photo[0]['url'] ?>" />
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


