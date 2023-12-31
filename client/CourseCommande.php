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
    <nav class="bg-black h-12">
        <div class="mx-auto max-w-7xl max-h-7xl px-2 sm:px-6 lg:px-8">
            <div class="flex flex-row space-x-24 items-center">

                <a href="../index.php" class="text-gray-300 text-2xl font-weight">TAXEASY</a>


                <a href="../index.php" class="text-white font-medium shadow-2xl hover:text-slate-300">à propos</a>
                <a href="paiement.php" class="text-white font-medium shadow-2xl  hover:text-slate-300">Vos historiques de courses</a>
                <!-- <a href="../index.php" class="text-white font-medium shadow-2xl">à propos</a> -->

                <form action="../deconnection.php">
                    <input type="submit" class="text-white font-medium shadow-2xl  hover:text-slate-300" name="Deconnexion" value="Deconnexion">Deconnexion</button>
                </form>
            </div>

        </div>
    </nav>  
    <div class='flex flex-col gap-8 relative top-28 left-96 w-1/2 h-3/4 border border-8  border-black self-center justify-self-center indent'>
    <h1 class='text-5xl text-center'>Confirmation de la course </h1>
    <p class='text-lg text-center'>Nous confirmons votre course en direction de l'adresse suivante : </p>
    <?php 
    include_once '../classes/bdd.php';
    $base = new Bdd();
    $base = $base->getBdd();
    session_start();    
    $IdClient = $_SESSION["Id"];
    $IdCourse = $_SESSION["IdCourse"];
    
    $query = "SELECT adresse.Rue,adresse.Numero,adresse.Vile FROM adresse JOIN course ON adresse.Id = course.IdAdresseFin WHERE course.Id = '$IdCourse'";


    $rq = $base->prepare($query);
    $rq->execute();
    $rep=$rq->fetch(PDO::FETCH_ASSOC);
    


    

    $adresseString = $rep["Numero"] . " , "  . $rep["Rue"] . " " . $rep["Vile"] . " .";

    echo "<p class='text-lg text-center font-bold' >$adresseString</p>";
    
    $query = "SELECT DateReservation FROM course WHERE Id='$IdCourse'";
    $rq = $base->prepare($query);
    $rq->execute();
    $rep=$rq->fetch(PDO::FETCH_ASSOC);
    

    echo "<p class='text-lg text-center font-bold'>Date et Heure de reservation : ". $rep['DateReservation']."</p>";
    echo "<p class='text-lg text-center'>N'hésitez pas à verifier vos emails avec la confirmation de la commande et une confirmation de votre prise en charge au plus vite.</p>";
    
    
    ?>
    <div class="self-center flex ">
    <a href="paiement.php" class="self-center border border-5 rounded-lg bg-black text-white w-64 text-center font-bold">Payer et Gérer vos courses</a>
    <a href="SelectionCourse.php" class="self-center border border-5 rounded-lg bg-black text-white w-64 text-center font-bold">Recommander une course</a>
    </div>
     
    </div>




    </body>
</html>