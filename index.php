<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeConnectKS - Ballina</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <nav class="navbar">
        <div class="container nav-container">
            <div class="logo">
                <div class="logo-badge">W</div>
                <div class="logo-text">
                    <span class="logo-title">WeConnect</span>
                    <span class="logo-subtitle">KOSOVA</span>
                </div>
            </div>
            <ul class="nav-links">
                <li><a href="#" class="active">Ballina</a></li>
                <li><a href="events.php">Eventet</a></li>
                <li><a href="groups.php">Grupet</a></li>
                <li><a href="about.php">Rreth Nesh</a></li>
                <li><a href="contacts.php">Kontakt</a></li>
            </ul>
            <div class="auth-buttons">
                <a href="login.php" class="btn-text">Hyni</a>
                <a href="register.php" class="btn-primary">Regjistrohu</a>
            </div>
        </div>
    </nav>

    <header class="hero-slider">
        <div class="slide active" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1920&h=1080&fit=crop');">
            <div class="container slide-content">
                <span class="badge badge-art">KOMUNITET</span>
                <h1>Klubi i Librave Prishtina</h1>
                <p>Bashkohu me ne per diskutime te gjalla rreth librave. Gjej njerez me interesa te ngjashme dhe krijoni lidhje te reja.</p>
                <a href="events.html" class="btn-primary-large">Bashkohu</a>
            </div>
        </div>

        <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=1920&h=1080&fit=crop');">
            <div class="container slide-content">
                <span class="badge badge-art">KOMUNITET</span>
                <h1>Klubi i Filmit Prishtina</h1>
                <p>Shiko filma dhe diskuto mesazhet e tyre me komunitetin. Ambiente miqesore per te gjithe dashamiret e kinemase.</p>
                <a href="events.html" class="btn-primary-large">Zbulo Me Shume</a>
            </div>
        </div>

        <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('photo/maratona.jpg');">
            <div class="container slide-content">
                <span class="badge badge-sport">KOMUNITET</span>
                <h1>Klubi i Vrapimit Prishtina</h1>
                <p>Vrapo bashke me komunitetin. Nga fillestaret deri te profesionistet, te gjithe jane te mirepritur.</p>
                <a href="events.html" class="btn-primary-large">Bashkohu Tani</a>
            </div>
        </div>

        <button class="slider-btn prev-btn" onclick="changeSlide(-1)">&#10094;</button>
        <button class="slider-btn next-btn" onclick="changeSlide(1)">&#10095;</button>
    </header>

    <section class="section-padding bg-light">
        <div class="container">
            <div class="section-header-flex">
                <div>
                    <h2>Me te njohurat kete jave</h2>
                    <p class="text-muted">Klubet dhe eventet qe po terheqin komunitetin. Bashkohu me njerez qe ndajne interesat e tua dhe krijo lidhje te verteta.</p>
                </div>
                <a href="events.html" class="link-blue">Shiko te gjitha eventet 📅</a>
            </div>

            <div class="trending-grid">
                <div class="card trending-card">
                    <div class="card-image">
                        <span class="date-badge">Çdo te marte</span>
                        <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=600&h=400&fit=crop" alt="Book Club">
                    </div>
                    <div class="card-body">
                        <span class="tag tag-art">Komunitet</span>
                        <span class="location-text">Prishtine</span>
                        <h3>Klubi i Librave Prishtina</h3>
                        <p class="card-desc">Diskuto librat me njerez qe duan te ndajne mendimet e tyre. Bashkohu per lexime dhe diskutime te gjalla.</p>
                        <div class="card-footer">
                            <span class="price">Falas</span>
                            <a href="events.html" class="btn-arrow" aria-label="Shfletoni me shume">→</a>
                        </div>
                    </div>
                </div>

                <div class="card trending-card">
                    <div class="card-image">
                        <span class="date-badge">Çdo te enjte</span>
                        <img src="https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=600&h=400&fit=crop" alt="Movie Club">
                    </div>
                    <div class="card-body">
                        <span class="tag tag-art">Komunitet</span>
                        <span class="location-text">Prishtine</span>
                        <h3>Klubi i Filmit Prishtina</h3>
                        <p class="card-desc">Shiko filma dhe diskuto me komunitetin. Çdo jave nje film i ri dhe diskutim per mesazhin e tij.</p>
                        <div class="card-footer">
                            <span class="price">Falas</span>
                            <a href="events.html" class="btn-arrow" aria-label="Shfletoni me shume">→</a>
                        </div>
                    </div>
                </div>
                
                <div class="card trending-card">
                    <div class="card-image">
                        <span class="date-badge">Çdo te premte</span>
                        <img src="https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?w=600&h=400&fit=crop" alt="Game Night">
                    </div>
                    <div class="card-body">
                        <span class="tag tag-art">Komunitet</span>
                        <span class="location-text">Prishtine</span>
                        <h3>Nate Lojerash Prishtina</h3>
                        <p class="card-desc">Mblidhuni per te luajtur lojera tavoline dhe te njohesh njerez te rinj. Ambiente miqesore dhe argetuese.</p>
                        <div class="card-footer">
                            <span class="price">Falas</span>
                            <a href="events.html" class="btn-arrow" aria-label="Shfletoni me shume">→</a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <?php require_once 'includes/footer.php'; ?>

    <script src="script.js"></script>
</body>
</html>