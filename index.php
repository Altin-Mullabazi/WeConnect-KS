<?php
require_once 'includes/services/EventService.php';
$eventService = new EventService();
$trendingEvents = [];
try {
    $trendingEvents = $eventService->getLatest(3);
} catch (Exception $e) {
    $trendingEvents = [];
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeConnectKS - Ballina</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php require_once 'includes/header.php'; ?>
    <header class="hero-slider">
        <div class="slide active" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=1920&h=1080&fit=crop');">
            <div class="container slide-content">
                <span class="badge badge-art">KOMUNITET</span>
                <h1>Klubi i Librave Prishtina</h1>
                <p>Bashkohu me ne per diskutime te gjalla rreth librave. Gjej njerez me interesa te ngjashme dhe krijoni lidhje te reja.</p>
                <a href="events.php" class="btn-primary-large">Bashkohu</a>
            </div>
        </div>

        <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=1920&h=1080&fit=crop');">
            <div class="container slide-content">
                <span class="badge badge-art">KOMUNITET</span>
                <h1>Klubi i Filmit Prishtina</h1>
                <p>Shiko filma dhe diskuto mesazhet e tyre me komunitetin. Ambiente miqesore per te gjithe dashamiret e kinemase.</p>
                <a href="events.php" class="btn-primary-large">Zbulo Me Shume</a>
            </div>
        </div>

        <div class="slide" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('photo/maratona.jpg');">
            <div class="container slide-content">
                <span class="badge badge-sport">KOMUNITET</span>
                <h1>Klubi i Vrapimit Prishtina</h1>
                <p>Vrapo bashke me komunitetin. Nga fillestaret deri te profesionistet, te gjithe jane te mirepritur.</p>
                <a href="events.php" class="btn-primary-large">Bashkohu Tani</a>
            </div>
        </div>

        <button class="slider-btn prev-btn" onclick="changeSlide(-1)">&#10094;</button>
        <button class="slider-btn next-btn" onclick="changeSlide(1)">&#10095;</button>
    </header>

    <section class="section-padding bg-light">
        <div class="container">
            <div class="section-header-flex">
                <div>
                    <h2>Me te shikuarat kete jave</h2>
                    <p class="text-muted">Klubet dhe eventet qe po terheqin komunitetin. Bashkohu me njerez qe ndajne interesat e tua dhe krijo lidhje te verteta.</p>
                </div>
                <a href="events.php" class="link-blue">Shiko te gjitha eventet 📅</a>
            </div>

            <div class="trending-grid">
                <?php if (!empty($trendingEvents)): ?>
                    <?php foreach ($trendingEvents as $event): ?>
                    <div class="card trending-card">
                        <div class="card-image">
                            <?php if (!empty($event['event_date'])): ?>
                                <span class="date-badge"><?php echo date('d M Y', strtotime($event['event_date'])); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($event['image'])): ?>
                                <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>">
                            <?php else: ?>
                                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 200px; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">📅</div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($event['category'])): ?>
                                <span class="tag tag-art"><?php echo htmlspecialchars($event['category']); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($event['location'])): ?>
                                <span class="location-text"><?php echo htmlspecialchars($event['location']); ?></span>
                            <?php endif; ?>
                            <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                            <p class="card-desc"><?php echo htmlspecialchars(mb_substr($event['description'] ?? '', 0, 120)) . (mb_strlen($event['description'] ?? '') > 120 ? '...' : ''); ?></p>
                            <div class="card-footer">
                                <span class="price">Falas</span>
                                <a href="event.php?id=<?php echo (int)$event['id']; ?>" class="btn-arrow" aria-label="Shiko më shumë">→</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                <div class="card trending-card">
                    <div class="card-image">
                        <span class="date-badge">Çdo të martë</span>
                        <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=600&h=400&fit=crop" alt="Book Club">
                    </div>
                    <div class="card-body">
                        <span class="tag tag-art">Komunitet</span>
                        <span class="location-text">Prishtinë</span>
                        <h3>Klubi i Librave Prishtina</h3>
                        <p class="card-desc">Diskuto librat me njerëz që duan të ndajnë mendimet e tyre. Bashkohu për lexime dhe diskutime të gjalla.</p>
                        <div class="card-footer">
                            <span class="price">Falas</span>
                            <a href="events.php" class="btn-arrow" aria-label="Shfletoni më shumë">→</a>
                        </div>
                    </div>
                </div>
                <div class="card trending-card">
                    <div class="card-image">
                        <span class="date-badge">Çdo të enjte</span>
                        <img src="https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=600&h=400&fit=crop" alt="Movie Club">
                    </div>
                    <div class="card-body">
                        <span class="tag tag-art">Komunitet</span>
                        <span class="location-text">Prishtinë</span>
                        <h3>Klubi i Filmit Prishtina</h3>
                        <p class="card-desc">Shiko filma dhe diskuto me komunitetin. Çdo javë një film i ri dhe diskutim për mesazhin e tij.</p>
                        <div class="card-footer">
                            <span class="price">Falas</span>
                            <a href="events.php" class="btn-arrow" aria-label="Shfletoni më shumë">→</a>
                        </div>
                    </div>
                </div>
                <div class="card trending-card">
                    <div class="card-image">
                        <span class="date-badge">Çdo të premte</span>
                        <img src="https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?w=600&h=400&fit=crop" alt="Game Night">
                    </div>
                    <div class="card-body">
                        <span class="tag tag-art">Komunitet</span>
                        <span class="location-text">Prishtinë</span>
                        <h3>Natë Lojërash Prishtina</h3>
                        <p class="card-desc">Mblidhuni për të luajtur lojëra tavoline dhe të njohësh njerëz të rinj. Ambiente miqësore dhe argëtuese.</p>
                        <div class="card-footer">
                            <span class="price">Falas</span>
                            <a href="events.php" class="btn-arrow" aria-label="Shfletoni më shumë">→</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php require_once 'includes/footer.php'; ?>

    <script src="script.js"></script>
</body>
</html>