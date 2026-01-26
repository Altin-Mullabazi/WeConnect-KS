<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventi - WeConnectKS</title>
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
                <li><a href="index.php">Ballina</a></li>
                <li><a href="events.php" class="active">Eventet</a></li>
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

    <div class="section-padding">
        <div class="container">
            <a href="events.html" class="back-link">← Kthehu te Eventet</a>
            
            <div class="event-header">
                <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1200&h=600&fit=crop" alt="Book Club Prishtina" class="event-image">
                <div class="event-info">
                    <span class="badge badge-art">KOMUNITET</span>
                    <h1>Book Club Prishtina</h1>
                    <p class="event-date">Çdo te marte, 18:00</p>
                    <p class="event-location">Libraria Dituria, Prishtine</p>
                </div>
            </div>

            <div class="event-details">
                <div class="event-main">
                    <h2>Rreth Klubit</h2>
                    <p>Book Club Prishtina eshte nje grup i hapur per te gjithe qe duan te diskutojne librat qe lexojne. Bashkohu me ne per diskutime te gjalla, ndarje te ideve dhe lidhje me njerez me interesa te ngjashme.</p>
                    <p>Çdo muaj zgjedhim nje liber te ri dhe mblidhemi per te diskutuar. Nuk ka presion - lexo sa deshiron, dhe vije te diskutosh edhe nese nuk e ke perfunduar.</p>

                    <h3>Libri i Muajit</h3>
                    <ul class="event-program">
                        <li>
                            <strong>Qershor 2025</strong>
                            <span>"Princi i Vogel" - Antoine de Saint-Exupéry</span>
                        </li>
                        <li>
                            <strong>Korrik 2025</strong>
                            <span>"Shqiperia dhe Shqiptaret" - Ismail Kadare</span>
                        </li>
                        <li>
                            <strong>Gusht 2025</strong>
                            <span>Te anashkaluara - zgjedhje e anetareve</span>
                        </li>
                    </ul>

                    <h3>Çfare t'prese</h3>
                    <p>Diskutime te hapura rreth librave, kafe dhe sherbesa miqesore. Ambiente e rehatshme ku mund te ndash mendimet e tua dhe te degjosh perspektiva te tjera.</p>
                </div>

                <div class="event-sidebar">
                    <div class="event-card">
                        <h3>Detajet</h3>
                        <div class="detail-item">
                            <strong>Frekuenca:</strong>
                            <span>Çdo te marte</span>
                        </div>
                        <div class="detail-item">
                            <strong>Koha:</strong>
                            <span>18:00 - 20:00</span>
                        </div>
                        <div class="detail-item">
                            <strong>Lokacioni:</strong>
                            <span>Libraria Dituria</span>
                        </div>
                        <div class="detail-item">
                            <strong>Cmimi:</strong>
                            <span>Falas</span>
                        </div>
                    </div>

                    <a href="#" class="btn-primary-large" style="display: block; text-align: center; margin-top: 20px;">Bashkohu</a>

                    <div class="event-card" style="margin-top: 20px;">
                        <h3>Organizator</h3>
                        <p>Book Club Prishtina</p>
                        <p class="text-muted">Grupi i librave ne Prishtine. Tani me 50+ anetare aktive.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <?php require_once 'includes/footer.php'; ?>

    <script src="script.js"></script>
</body>
</html>