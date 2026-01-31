<?php
require_once 'includes/services/EventService.php';
require_once 'includes/services/NewsService.php';
require_once 'includes/repositories/UserRepository.php';

$eventService = new EventService();
$newsService = new NewsService();
$userRepo = new UserRepository();

$totalEvents = $eventService->getAll();
$totalNews = $newsService->getTotalCount();
$totalUsers = $userRepo->count();
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeConnectKS - Rreth Nesh</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .about-hero {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 3rem auto;
        }
        .about-hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }
        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        .value-card {
            background: #fff;
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            text-align: center;
            transition: transform 0.3s;
        }
        .value-card:hover {
            transform: translateY(-5px);
        }
        .value-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }
        .stat-section {
            background-color: var(--dark);
            color: white;
            padding: 60px 0;
            margin-top: 40px;
        }
        .stat-grid {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            text-align: center;
            gap: 2rem;
        }
        .stat-item h3 {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        .team-member {
            text-align: center;
        }
        .team-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
            border: 3px solid var(--primary);
        }
    </style>
</head>
<body>

    <?php require_once 'includes/header.php'; ?>

    <main>
        <section class="section-padding bg-light" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1920&h=1080&fit=crop'); background-size: cover; background-position: center; background-attachment: fixed;">
            <div class="container">
                <div class="about-hero" style="color: white;">
                    <span class="badge badge-tech" style="background-color: var(--primary); border: none;">Misioni Yne</span>
                    <h1 style="color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Gjej Komunitetin Tend, Krijo Lidhje Te Reja</h1>
                    <p style="font-size: 1.1rem; color: rgba(255,255,255,0.95); text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                        WeConnectKS eshte nje platforme e ngrohte dhe miqesore ku rinia e Kosoves mund te gjeje shoqeri, te ndaje interesa dhe te krijoje lidhje te verteta. 
                        Ne besojme se çdo njeri ka diçka te veçante per te ndare, dhe ketu gjen vendin e tyre.
                    </p>
                </div>
            </div>
        </section>

        <section class="section-padding">
            <div class="container">
                <div class="text-center">
                    <h2 class="mb-5">Vlerat Tona Kryesore</h2>
                </div>
                
                <div class="values-grid">
                    <div class="value-card">
                        <span class="value-icon">🤝</span>
                        <h3>Komuniteti i Ngrohte</h3>
                        <p class="text-muted">Ne krijojme hapesira ku njerezit ndihen te sigurt dhe te mirepritur. Bashkohu me book clubs, movie nights, game groups dhe me shume. Çdo njeri ka vendin e vet.</p>
                    </div>

                    <div class="value-card">
                        <span class="value-icon">💬</span>
                        <h3>Diskutime Te Gjalla</h3>
                        <p class="text-muted">Nga librat qe lexojme deri te filmat qe shohim, ketu diskutojme dhe mesojme nga njeri-tjetri. Shkembim ideje dhe pervojash me njerez qe kuptojne interesat e tua.</p>
                    </div>

                    <div class="value-card">
                        <span class="value-icon">✨</span>
                        <h3>Per Çdo Personalitet</h3>
                        <p class="text-muted">Qofte introvert apo ekstrovert, qofte dashamires i librave apo i muzikes, ketu gjen komunitetin tend. Ambiente miqesore per te gjithe.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="stat-section">
            <div class="container">
                <div class="stat-grid">
                    <div class="stat-item">
                        <h3><?php echo count($totalEvents); ?>+</h3>
                        <p>Evente te Publikuara</p>
                    </div>
                    <div class="stat-item">
                        <h3><?php echo $totalUsers; ?>+</h3>
                        <p>Perdorues Aktive</p>
                    </div>
                    <div class="stat-item">
                        <h3><?php echo $totalNews; ?>+</h3>
                        <p>Lajme te Publikuara</p>
                    </div>
                    <div class="stat-item">
                        <h3>24/7</h3>
                        <p>Mbeshtetje per Komunitetin</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-padding bg-light text-center">
            <div class="container">
                <h2 style="margin-bottom: 1rem;">Gati per te gjetur komunitetin tend?</h2>
                <p class="text-muted mb-5" style="max-width: 600px; margin-left: auto; margin-right: auto;">
                    Nga book clubs deri te movie nights, nga game groups deri te running clubs - ketu gjen njerez qe ndajne interesat e tua. Regjistrohu dhe fillo te krijojsh lidhje te reja.
                </p>
                <a href="register.php" class="btn-primary-large">Bashkohu Me Ne</a>
            </div>
        </section>

    </main>

    <?php require_once 'includes/footer.php'; ?>

    <script src="script.js"></script>
</body>
</html>