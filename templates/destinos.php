<?php
$title = "Destinos - InkaTours";
$active_page = 'destinos';
include 'header.php';
?>

    <section class="page-hero">
        <div class="container">
            <h1>Nuestros Destinos Sostenibles</h1>
            <p>Explora los lugares más increíbles de Cusco con nuestro enfoque responsable</p>
        </div>
    </section>

    <section class="destinos-filtros">
        <div class="container">
            <div class="filtros-grid">
                <div class="filtro-group">
                    <label for="filtro-tipo">Tipo de destino:</label>
                    <select id="filtro-tipo">
                        <option value="all">Todos</option>
                        <option value="cultural">Cultural</option>
                        <option value="naturaleza">Naturaleza</option>
                        <option value="aventura">Aventura</option>
                    </select>
                </div>
                <div class="filtro-group">
                    <label for="filtro-dificultad">Dificultad:</label>
                    <select id="filtro-dificultad">
                        <option value="all">Todas</option>
                        <option value="facil">Fácil</option>
                        <option value="moderada">Moderada</option>
                        <option value="dificil">Difícil</option>
                    </select>
                </div>
                <div class="filtro-group">
                    <label for="filtro-distancia">Distancia:</label>
                    <select id="filtro-distancia">
                        <option value="all">Cualquier distancia</option>
                        <option value="cercano">Menos de 50km</option>
                        <option value="medio">50-100km</option>
                        <option value="lejano">Más de 100km</option>
                    </select>
                </div>
                <div class="filtro-group">
                    <label>
                        <input type="checkbox" id="filtro-sostenible" checked>
                        Solo sostenibles
                    </label>
                </div>
            </div>
        </div>
    </section>

    <section class="destinos-lista">
        <div class="container">
            <div class="destinos-grid" id="destinos-container">
                <!-- Los destinos se cargarán con JavaScript -->
            </div>
            
            <div class="paginacion" id="paginacion">
                <!-- La paginación se generará con JavaScript -->
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>