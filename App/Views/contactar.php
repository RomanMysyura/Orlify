<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/main.css">

    <title>Contactar</title>
</head>

<body>
    <?php include 'navbar.php'; ?>
 



    <form method="post" action="/enviarcontactar" >
        <input type="hidden" name="action" value="/enviarcontactar">


        <div
            class="bg-white border border-slate-200 grid grid-cols-6 gap-2 rounded-xl p-2 text-sm w-full max-w-md  m-auto mt-10 ">
            <h1 class="text-center text-gray-500 text-xl bg-white font-bold col-span-6">Enviar missatge</h1>
            <input type="email" id="email" title="email" name="email" placeholder="Email"
                class="bg-slate-100 text-slate-600 h-10 placeholder:text-slate-600 placeholder:opacity-50 border border-slate-200 col-span-6 resize-none outline-none rounded-lg p-2 duration-300 focus:border-slate-600">
            <input placeholder="El teu missatge..." title="missatge" type="text" name="mensaje" id="error_notification"
                class="bg-slate-100 text-slate-600 h-28 placeholder:text-slate-600 placeholder:opacity-50 border border-slate-200 col-span-6 resize-none outline-none rounded-lg p-2 duration-300 focus:border-slate-600"></input>

            <span class="col-span-2"></span>
            <button type="submit" title="enviar"
                class="bg-slate-100 stroke-slate-600 border border-slate-200 col-span-2 flex justify-center rounded-lg p-2 duration-300 hover:border-slate-600 hover:text-white focus:stroke-blue-200 focus:bg-blue-400">
                <svg fill="none" viewBox="0 0 24 24" height="30px" width="30px" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5"
                        d="M7.39999 6.32003L15.89 3.49003C19.7 2.22003 21.77 4.30003 20.51 8.11003L17.68 16.6C15.78 22.31 12.66 22.31 10.76 16.6L9.91999 14.08L7.39999 13.24C1.68999 11.34 1.68999 8.23003 7.39999 6.32003Z">
                    </path>
                    <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5"
                        d="M10.11 13.6501L13.69 10.0601"></path>
                </svg>
            </button>
        </div>
    </form>
    <!-- <div role="alert" class="alert alert-success">
  <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
  <span>Missatge enviat correctament!</span>
</div>
<div role="alert" class="alert alert-error">
  <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
  <span>Hi ha hagut un error al enviar el missatge.</span>
</div> -->
    <?php include 'footer.php'; ?>
</body>

</html>

<!-- a -->