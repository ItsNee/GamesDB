<!DOCTYPE html>
<html lang="en">
    <?php
    //nee test edit
    include "head.inc.php";
    ?>
    <body id="page-top">
        <?php
        include "navPostLogin.inc.php";
        ?>
        
        <section id="searchBar_and_filter" class="intro">
            <div class="d-flex h-50">
                <div class="container">                    
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="d-flex ">                                
                                <div class="input-group justify-content-start dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-target="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Filter by Genre
                                    </button>
                                    <div class="dropdown-menu" id="dropdownMenuButton">
                                        <!--get distinct genres-->
                                        <?php
                                            include "db.inc.php";                                            
                                            
                                            $query = "SELECT DISTINCT gameGenre FROM games";
                                            $result = mysqli_query($conn, $query);
                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                                    $gameGenre = $row["gameGenre"];
                                                    echo '<a class="dropdown-item" href="#">'.ucfirst($gameGenre).'</a>';
                                                }
                                            } else {
                                                echo "0 results";                                                
                                            }
                                        ?>
                                        
                                        <!--find ways to select data based on selected genre-->
                                        
                                    </div>
                                </div>
                                <div class="input-group justify-content-end">
                                    <div class="form-outline">
                                        <input type="search" id="form1" class="form-control form-control-lg" placeholder="Search for games here!"/>                                        
                                    </div>        
                                    <button type="button" class="btn btn-primary">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section>
        </section>
        
        <?php
        include "footer.inc.php";
        ?>
        

        
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
