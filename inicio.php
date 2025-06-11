<?php
session_start();


// Duración máxima de inactividad en segundos (5 segundos para probar)
$inactivity_timeout = 15;

// === INICIO DE LA SECCIÓN A MODIFICAR ===
// Este bloque solo debe ejecutarse si el usuario está LOGUEADO
if (isset($_SESSION['id_usuario']) && !empty($_SESSION['id_usuario'])) { // <--- ¡USA ESTA!
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactivity_timeout)) {
        session_unset();
        session_destroy();
        // Redirigir a logout.php con el motivo de inactividad
        // El mensaje de logout se establecerá en logout.php
        header("Location: logout.php?reason=inactivity");
        exit();
    }

    // Actualizar el tiempo de la última actividad en cada carga de página (PARA USUARIOS LOGUEADOS)
    $_SESSION['last_activity'] = time();
} // <--- AÑADE ESTA OTRA LÍNEA DE CIERRE
// === FIN DE LA SECCIÓN A MODIFICAR ===

// === MANEJAR EL MENSAJE DE LOGOUT (ahora viene de la URL) ===
$logout_message = '';
if (isset($_GET['message'])) {
    $logout_message = htmlspecialchars($_GET['message']);
}

// Comprueba si hay un error de login que viene de validar_login.php (si lo hubiera)
$error = '';
if (isset($_SESSION['error_login'])) {
    $error = $_SESSION['error_login'];
    unset($_SESSION['error_login']);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <title>SmarTech Tienda</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilo_inicio.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>


<body>

<div id="overlay" class="overlay hidden"></div>

<div id="menuCategorias" class="menu-categorias hidden">
    <ul>
        <li><a href="#">Tecnología</a></li>
        <li><a href="#">Hogar</a></li>
        <li><a href="#">Muebles</a></li>
        <li><a href="#">Deporte</a></li>
        <li><a href="#">Multiservicios</a></li>
    </ul>
</div>

<header class="header-principal">
    <div class="logo">
        <a href="inicio.php"><img src="img/logo.png" alt="Mi Tienda Logo"></a>
    </div>

    <div class="header-buttons-middle">
    <div class="categorias-btn-container">
        <button id="btnCategorias" class="btn-categorias">
            <span class="icono-menu">&#9776;</span> Categorías
        </button>
    </div>
    <div class="ofertas-btn-container">
        <a href="ofertas.php" class="btn-ofertas">
            ST Ofertas
        </a>
    </div>
    <div class="formas-pago-btn-container">
        <a href="formas_de_pago.php" class="btn-formas-pago">Formas de Pago</a>
    </div>
</div>

    <div class="header-search-wrapper custom-search-center">
        <div class="search-input-container">
            <input type="text" placeholder="¿Qué estas buscando?" class="search-input">
            <button class="search-button">
                <svg xmlns="http://www.w3.org/2000/svg" class="search-icon" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 21l-4.35-4.35M10 8a7 7 0 100 14A7 7 0 0010 8z" />
                </svg>
            </button>
        </div>
    </div>

    <div class="header-right-group">
    <div class="menu-derecha">
        <?php if (isset($_SESSION['usuario'])): ?>
            <img src="img/favicon.ico" alt="Icono de usuario" style="height: 24px; vertical-align: middle; margin-right: 8px;">
            <span style="color: black; font-weight: bold; margin-right: 15px;">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</span>
            <a href="logout.php" class="logout-button">Cerrar sesión</a>
        <?php else: ?>
            <img src="img/favicon.ico" alt="Icono de usuario" style="height: 24px; vertical-align: middle; margin-right: 8px;">
            <a href="iniciar_sesion.php" class="login-button">Iniciar sesión</a>
        <?php endif; ?>
    </div>
</div>
</header>
<?php if (!empty($error)): ?>
    <div class="contenedor error-message-box">
        <h2 class="error-title"><?php echo htmlspecialchars($error); ?></h2>
        <p class="error-text">Has iniciado sesión incorrectamente. Intenta de nuevo.</p>
    </div>
<?php endif; ?>


<div class="barra-promocional">
    <div class="barra-left">
        <img src="img/carrito.png" alt="Carrito" class="icono-carrito">
    </div>
    <div class="barra-center">
        <span class="texto-fondo-blanco">
            Envío gratis a todo el Perú
            <span class="texto-destacado">en Telefonia, Cómputo y Pequeños Electros</span>
        </span>
    </div>
    <div class="barra-right">
    </div>
</div>

<section class="slider">
    <div class="slides" id="slideContainer">
        <div class="slide"><img src="slider1.webp" alt="Slide 1"></div>
        <div class="slide"><img src="slider2.webp" alt="Slide 2"></div>
        <div class="slide"><img src="slider3.webp" alt="Slide 3"></div>
        <div class="slide"><img src="slider4.webp" alt="Slide 4"></div>
    </div>
</section>


<div class="barra-container">
    <div class="barra-izquierda">
        <span class="texto-hasta">hasta</span>
        <span class="texto-150">S/150</span>
        <span class="texto-dscto-adic">
            <span>DSCTO</span>
            <span>ADICIONAL</span>
        </span>
        <span class="texto-resto">
            EN PRODUCTOS SELECCIONADOS<br>
            POR COMPRA MAYOR A S/600
        </span>
    </div>

    <div class="barra-derecha">
        <span class="texto-exclusivo">
            <span>exclusivo con</span>
            <span>tu tarjeta</span>
        </span>
        <img src="img/tarjeta.png" alt="Tarjeta" class="icono-tarjeta">
        <span class="texto-visa">VISA</span>
        <span class="texto-cupon">
            <span>usa el</span>
            <span>cupon</span>
        </span>
        <div class="rectangulo-codigo">VISA15</div>
        <div class="btn-ver-ofertas">Ver Ofertas</div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const sliderInferior = document.getElementById('sliderInferior');
    const leftBtn = document.querySelector('.left-btn');
    const rightBtn = document.querySelector('.right-btn');

    const scrollAmount = 300; // píxeles a desplazar

    leftBtn.addEventListener('click', () => {
        sliderInferior.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });

    rightBtn.addEventListener('click', () => {
        sliderInferior.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });
});
</script>
<div class="beneficios-container">
    <h2 class="titulo-beneficios">Más Productos</h2>
</div>
<div class="slider-wrapper">
    <button class="slider-btn left-btn">&#9664;</button>
    <div class="slider" id="sliderInferior">
        <div class="slider-item">
            <a href="portada/producto1.php">
                <img src="img/imagen1.jpg" alt="Imagen 1" />
            </a>
        </div>
        <div class="slider-item">
            <a href="producto2.php">
                <img src="img/imagen2.jpg" alt="Imagen 2" />
            </a>
        </div>
        <div class="slider-item">
            <img src="img/imagen3.jpg" alt="Imagen 3" />

        </div>
        <div class="slider-item">
            <img src="img/imagen4.jpg" alt="Imagen 4" />
        </div>
        <div class="slider-item">
            <img src="img/imagen5.jpg" alt="Imagen 5" />

        </div>
        <div class="slider-item">
            <img src="img/imagen6.jpg" alt="Imagen 6" />

        </div>
        <div class="slider-item">
            <img src="img/imagen7.jpg" alt="Imagen 7" />

        </div>
        <div class="slider-item">
            <img src="img/imagen8.jpg" alt="Imagen 8" />

        </div>
        <div class="slider-item">
            <img src="img/imagen9.jpg" alt="Imagen 9" />

        </div>
        <div class="slider-item">
            <img src="img/imagen10.jpg" alt="Imagen 10" />

        </div>
    </div>
    <button class="slider-btn right-btn">&#9654;</button>
</div>

<footer>
    <div class="footer-container">
        <div class="footer-section">
            <h3 class="footer-heading">Contáctanos</h3>
            <ul class="footer-links">
                <li><a href="#">Chatea con nosotros</a></li>
                <li><a href="#">Te respondemos las 24 horas</a></li>
                <li><a href="#">Teléfono: (01) 610-4000</a></li>
                <li>Lunes a Domingo de 8:00 am a 9:00 pm</li>
                <li><a href="#">WhatsApp</a></li>
                <li><a href="#">Tiendas físicas a nivel nacional</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3 class="footer-heading">Secciones destacadas</h3>
            <ul class="footer-links">
                <li><a href="#">¿Cómo comprar en SmarTech?</a></li>
                <li><a href="#">Cambios y devoluciones</a></li>
                <li><a href="#">Despacho a domicilio</a></li>
                <li><a href="#">Mis Pedidos</a></li>
                <li><a href="#">Devoluciones en sala de casa</a></li>
                <li><a href="#">Super Garantía</a></li>
                <li><a href="#">Garantía de Electro y Maquinas de Deporte</a></li>
                <li><a href="#">Gestión de Pedidos de Aparatos Electrónicos y Electrodomésticos (RAEE)</a></li>
                <li>
                    <a href="#" class="footer-link-icon">
                        <svg class="footer-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h6z"/><path d="M10 8h6"/><path d="M10 12h6"/><path d="M10 16h6"/></svg>
                        Libro de Reclamaciones
                    </a>
                </li>
            </ul>
        </div>

        <div class="footer-section">
            <h3 class="footer-heading">Servicio al Cliente</h3>
            <ul class="footer-links">
                <li><a href="#">Términos y Condiciones Generales</a></li>
                <li><a href="#">Bases y Condiciones de Promociones Comerciales</a></li>
                <li><a href="#">Políticas de cookies</a></li>
                <li><a href="#">Política de privacidad de datos personales</a></li>
                <li><a href="#">Derechos ARCO</a></li>
                <li><a href="#">Comprobación electrónica</a></li>
                <li><a href="#">Comprobante electrónico de venta</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3 class="footer-heading">Sobre SmarTech</h3>
            <ul class="footer-links mb-4">
                <li><a href="#">Nosotros</a></li>
                <li><a href="#">Nuestras tiendas</a></li>
                <li><a href="#">Trabaja con nosotros</a></li>
                <li><a href="#">Ventas mayoristas</a></li>
                <li><a href="#">Vende con nosotros</a></li>
                <li><a href="#">Canal de Ética - Ética SmarTech</a></li>
                <li><a href="#">Línea de denuncias</a></li>
                <li><a href="#">Black Friday</a></li>
                <li><a href="#">Cyber Days</a></li>
                <li><a href="#">Cyber Wow</a></li>
                <li><a href="#">Laptops</a></li>
                <li><a href="#">Televisores</a></li>
            </ul>
            <h3 class="footer-heading">¡Recibe nuestras ofertas y novedades!</h3>
            <p class="footer-newsletter-text">Suscríbete y recibe en tu inbox todas nuestras ofertas, descuentos y novedades.</p>
            <form class="newsletter-form">
                <input type="email" placeholder="Ingresa tu email" class="newsletter-input">
                <select class="newsletter-select">
                    <option value="">Tipo de documento</option>
                    <option value="DNI">DNI</option>
                    <option value="CE">Carnet de Extranjería</option>
                </select>
                <input type="text" placeholder="Número de documento" class="newsletter-input">
                <div class="privacy-checkbox-container">
                    <input type="checkbox" id="privacy-check" class="privacy-checkbox">
                    <label for="privacy-check" class="privacy-label">He leído la <a href="#" class="underline">Política de Privacidad</a> de SmarTech y autorizo el tratamiento de mis datos personales.</label>
                </div>
                <div class="privacy-checkbox-container">
                    <input type="checkbox" id="marketing-check" class="privacy-checkbox">
                    <label for="marketing-check" class="privacy-label">Autorizo a SmarTech a comunicar mis datos personales a sus empresas vinculadas y a sus proveedores de servicios para el desarrollo de acciones comerciales, novedades, promociones y descuentos, así como para la elaboración de perfiles.</label>
                </div>
                <button type="submit" class="newsletter-button">Suscribirme</button>
            </form>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="social-media-links">
            <span class="social-media-text">Síguenos en:</span>
            <a href="#" class="social-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.8 7.1c-.3 1.1-.3 2.3-.3 3.5v2.8c0 1.2 0 2.4.3 3.5C3.3 19 4.3 20 5.5 20.3c1.1.3 2.3.3 3.5.3h5.8c1.2 0 2.4 0 3.5-.3 1.2-.3 2.2-1.3 2.5-2.5.3-1.1.3-2.3.3-3.5v-2.8c0-1.2 0-2.4-.3-3.5-.3-1.2-1.3-2.2-2.5-2.5-1.1-.3-2.3-.3-3.5-.3H9c-1.2 0-2.4 0-3.5.3C4.3 4.3 3.3 5.3 2.8 7.1Z"/><path d="m10 15 5-3-5-3v6Z"/></svg>
            </a>
            <a href="#" class="social-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
            </a>
            <a href="#" class="social-icon">
                <svg class="lucide lucide-facebook" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
            </a>
        </div>
        <div class="payment-methods">
            <span class="payment-methods-text">Medios de pago:</span>
            <img src="https://placehold.co/40x25/FFFFFF/000000?text=VISA" alt="Visa" class="payment-icon">
            <img src="https://placehold.co/40x25/FFFFFF/000000?text=MC" alt="MasterCard" class="payment-icon">
            <img src="https://placehold.co/40x25/FFFFFF/000000?text=AMEX" alt="American Express" class="payment-icon">
            <img src="https://placehold.co/40x25/FFFFFF/000000?text=Diners" alt="Diners Club" class="payment-icon">
            <img src="https://placehold.co/40x25/FFFFFF/000000?text=SafetyPay" alt="SafetyPay" class="payment-icon">
        </div>
        <div class="secure-shop-text">
            Tienda 100% Segura <span class="vtex-text">VTEX</span>
        </div>
    </div>
    <div class="footer-legal-text">
        <p>Tiendas Peruanas S.A. RUC N° 20100051648. Todos los derechos reservados. Av. Aviación 2405 Piso 3, San Borja.</p>
        <p>Precios disponibles sólo en www.SmarTech.pe. Nuestros precios pueden variar sin previo aviso. Promociones exclusivas de la página web. Productos y/o disponibilidad de ofertas.</p>
    </div>
</footer>

<script>
    const btnCategorias = document.getElementById('btnCategorias');
    const menuCategorias = document.getElementById('menuCategorias');
    const overlay = document.getElementById('overlay');

    btnCategorias.addEventListener('click', () => {
        menuCategorias.classList.toggle('hidden');
        overlay.classList.toggle('hidden');
    });

    overlay.addEventListener('click', () => {
        menuCategorias.classList.add('hidden');
        overlay.classList.add('hidden');
    });
</script>


<div id="logoutModal" class="modal-overlay" style="display: <?php echo !empty($logout_message) ? 'flex' : 'none'; ?>;">
    <div class="modal-content">
        <h3>Mensaje del Sistema</h3>
        <p><?php echo htmlspecialchars($logout_message); ?></p>
        <button id="closeModalButton">Entendido</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoutModal = document.getElementById('logoutModal');
        const closeModalButton = document.getElementById('closeModalButton');

        if (closeModalButton && logoutModal) {
            closeModalButton.addEventListener('click', function() {
                // Ocultar el modal
                logoutModal.style.display = 'none';

                // Redirigir a la página principal (inicio.php)
                window.location.href = 'inicio.php';
            });
        }
    });
</script>

<script>
    // Este script del slider ya lo tenías y está bien, lo dejo aquí para completar el archivo
    let index = 0;
    const slides = document.getElementById("slideContainer");
    const totalSlides = slides.children.length;

    setInterval(() => {
        index = (index + 1) % totalSlides;
        slides.style.transform = `translateX(-${index * 100}%)`;
    }, 4000);
</script>

<?php
// AÑADE ESTA CONDICIÓN PHP AQUÍ para tu script de inactividad
if (isset($_SESSION['id_usuario']) && !empty($_SESSION['id_usuario'])) {
?>
    <script src="inactivity_logout.js"></script>
<?php
}
?>

</body>

</html>