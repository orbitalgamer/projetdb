<!DOCTYPE html>
<?php 
session_start();

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'blue': '#1e3a8a',
                        'black': '#030712',
                        'green': '#84cc16',
                        'white': '#FAF9F6'
                    },
                    height: {
                        '96': '64rem'
                    },
                    boxShadow: {
                        'base': "rgba(50, 50, 93, 0.25) 0px 30px 60px -12px inset, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px inset"
                    }
                }
            }
        }
    </script>

</head>

<body>
    <nav class="bg-black">
        <div class="mx-auto max-w-7xl max-h-7xl px-2 sm:px-6 lg:px-8">
            <div class="flex space-x-4">

                <span class="text-gray-300 text-2xl font-weight">TAXEASY</span>

                <form class="relative left-96" action="deconnection.php">
                    <input type="submit" class="text-white " name="Deconnexion" value="Deconnexion">Deconnexion</button>
                </form>
            </div>

        </div>
    </nav>
    <div class="mx-auto grid grid-cols-2 gap-4 bg-white">
        <div class="">

            <div id="textContent" class="relative top-20 left-10">
                <p class="text-5xl">
                    Ne vous préocupper plus jamais de vos trajets
                </p>

                <form class="relative top-36 w-3/4 h-96  flex flex-col gap-8" action="./client/selectionCourse.php"
                    method="POST">


                    <input type="submit"
                        class="border border-2 w-36  bg-black text-white rounded-full hover:drop-shadow-xl duration-100"
                        value="Commander" name="commander">
                </form>



            </div>

        </div>
        <div class="">
            <div id="imgContainer" class="relative top-20">
                <img class="mx-auto max-w-96 max-h-[46rem] shadow-lg"
                    src="lousvette-munoz-au6ERMLAr0o-unsplash.jpg">
            </div>
        </div>
</body>

</html>