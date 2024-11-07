<!DOCTYPE html>
    <html lang="en">
    
    <head>
        <script src="https://kit.fontawesome.com/8bd83915fa.js" crossorigin="anonymous"></script>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>El-Fatras</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    </head>
    
    <body style="background-color: #c7ffec;">
        <!-- NavBar -->
        <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="">El-Fatras</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                        <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="http://localhost/elfatras/">Buat Surat</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="http://localhost/elfatras/gtk.php">Daftar GTK</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" href="#">Kegiatan GTK</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="container">
        <!-- Tabel GTK -->
        <header>
            <br>
            <center>
            <h3>Daftar Guru Dan Tenaga Kependidikan</h3>
            </center>
        </header>


        <?php
            include "koneksi.php";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Lakukan sesuatu ketika tombol ditekan
            $query=mysqli_query($conn, "DELETE FROM `kegiatan_gtk`");
        }
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <button type="submit" name="submit" class="btn btn-success mt-3">Clear All</button>
        </form>

        <br>

        <table class="table table-striped container">
        <thead>
            <tr>
                <th>NO</th>
                <th>NAMA</th>
                <th>TANGGAL BERANGKAT</th>
                <th>TANGGAL KEMBALI</th>
                <th>KEGIATAN</th>
                <th>TEMPAT</th>
            </tr>
        </thead>
        <tbody>

            <?php
            include "koneksi.php";
            $query    =mysqli_query($conn, "SELECT * FROM kegiatan_gtk ORDER BY tgl_berangkat DESC");

            $a=1;
            while($gtk = mysqli_fetch_array($query)){
                echo "<tr>";
                echo "<td><b>".$a."</b></td>";
                echo "<td><b>".$gtk['nama']."</b></td>";
                echo "<td>".$gtk['tgl_berangkat']."</td>";
                echo "<td>".$gtk['tgl_kembali']."</td>";
                echo "<td>".$gtk['kegiatan']."</td>";
                echo "<td>".$gtk['tempat']."</td>";
                echo "</tr>";
                $a=$a+1;
            }
            ?>

        </tbody>
        </table>

        <p>Total: <?php echo mysqli_num_rows($query) ?></p>

        </div>


        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/8bd83915fa.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
    </html>