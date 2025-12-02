<?php
$title = "Actividades - InkaTours";
$active_page = 'actividades';
include 'header.php';
?>

    <section class="page-hero">
        <div class="container">
            <h1>Actividades con Impacto Positivo</h1>
            <p>Participa en experiencias que benefician a las comunidades locales y al medio ambiente</p>
        </div>
    </section>

    <section class="actividades-categorias">
        <div class="container">
            <div class="categorias-grid">
                <div class="categoria-card" data-categoria="cultural">
                    <i class="fas fa-landmark"></i>
                    <h3>Cultural</h3>
                    <p>Inmersión en tradiciones ancestrales</p>
                </div>
                <div class="categoria-card" data-categoria="aventura">
                    <i class="fas fa-hiking"></i>
                    <h3>Aventura</h3>
                    <p>Exploración responsable de la naturaleza</p>
                </div>
                <div class="categoria-card" data-categoria="comunidad">
                    <i class="fas fa-users"></i>
                    <h3>Comunitario</h3>
                    <p>Interacción directa con comunidades</p>
                </div>
                <div class="categoria-card" data-categoria="naturaleza">
                    <i class="fas fa-tree"></i>
                    <h3>Naturaleza</h3>
                    <p>Conservación y ecoturismo</p>
                </div>
            </div>
        </div>
    </section>

    <section class="actividades-lista">
        <div class="container">
            <h2>Todas las Actividades</h2>
            <div class="actividades-grid" id="actividades-container">
                <!-- Las actividades se cargarán con JavaScript -->
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>