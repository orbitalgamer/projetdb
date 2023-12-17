<!DOCTYPE html>
<html>
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

            </div>

        </div>
    </nav>
    
    <div class='flex flex-col gap-16 relative left-96 w-1/2 h-3/4 border border-5 self-center indent'>
    <h1 class='text-5xl text-center'>Votre course est reservé : </h1>
    <a href="paiement.php">Paiement et Facture de vos courses</a>
  
    
     
    </div>




    </body>
</html>