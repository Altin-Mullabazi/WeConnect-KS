<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakti — WeConnectKS</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/contacts.css">
</head>
<body>

    <?php require_once 'includes/header.php'; ?>

    <main>
        <div class="container contact-page">
            <div class="container contact-wrapper">
                <div class="left-panel">
                    <div>
                        <h2>Lidhu me ne</h2>
                        <p>Na shkruani per cdo pyetje ose sugjerim. Ekipi do t'ju ktheje pergjigje sa me pare.</p>

                        <div class="contact-info">
                            <div class="info-item">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z" fill="currentColor"/></svg>
                                <div class="info-content">
                                    <h4>Adresa</h4>
                                    <span>Rruga Tringe Smajli, Prishtine 10000</span>
                                </div>
                            </div>

                            <div class="info-item">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4l-8 5L4 8V6l8 5 8-5z" fill="currentColor"/></svg>
                                <div class="info-content">
                                    <h4>Email</h4>
                                    <span>info@weconnect-ks.com</span>
                                </div>
                            </div>

                            <div class="info-item">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.6 10.8a15.09 15.09 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1.1-.2 11.05 11.05 0 0 0 3.5.6 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h2.2a1 1 0 0 1 1 1 11.05 11.05 0 0 0 .6 3.5 1 1 0 0 1-.2 1.1L6.6 10.8z" fill="currentColor"/></svg>
                                <div class="info-content">
                                    <h4>Telefon</h4>
                                    <span>+383 44 432 336</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="social-icons">
                        <div class="social-icon">IG</div>
                        <div class="social-icon">FB</div>
                        <div class="social-icon">LN</div>
                    </div>
                </div>

                <div class="right-panel">
                    <form id="contactForm">
                        <div class="form-group">
                            <label for="name">Emri dhe Mbiemri</label>
                            <input type="text" id="name" placeholder="Shkruaj ketu emrin..." required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Adresa</label>
                            <input type="email" id="email" placeholder="emri@email.com" required>
                        </div>

                        <div class="form-group">
                            <label for="message">Mesazhi</label>
                            <textarea id="message" placeholder="Shkruani kerkesen tuaj ketu..." required></textarea>
                        </div>

                        <button type="submit" class="btn-submit">Dergo</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php require_once 'includes/footer.php'; ?>

    <script src="assets/js/contacts.js" defer></script>
</body>
</html>