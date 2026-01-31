<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupet - WeConnectKS</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/groups.css">
</head>
<body>

   <?php require_once 'includes/header.php'; ?>

    <section class="section-padding">
        <div class="container">
            <div class="section-header-flex">
                <div>
                    <h2>Bashkohu me Grupet Lokale</h2>
                    <p class="text-muted">Shfaq grupet lokale në Kosovë. Nga "Running Club Prishtina" deri te "Kosovo Board Gamers" - gjej komunitetin tuaj dhe krijo lidhje me njerez qe ndajne interesat e tua.</p>
                </div>
                <button class="btn-primary" onclick="toggleCreateGroupModal()">+ Krijo Grup</button>
            </div>
            <div class="filters-container">
                <div class="filter-group">
                    <input type="text" id="searchGroups" class="search-input" placeholder="Kërko grupet...">
                </div>
                <div class="filter-group">
                    <select id="categoryFilter" class="filter-select">
                        <option value="">Të gjitha kategorit</option>
                        <option value="Sport">Sport</option>
                        <option value="Kulturë">Kulturë</option>
                        <option value="Teknologji">Teknologji</option>
                        <option value="Libra">Libra</option>
                        <option value="Filma">Filma</option>
                        <option value="Lojëra">Lojëra</option>
                        <option value="Muzikë">Muzikë</option>
                        <option value="Tjeter">Tjeter</option>
                    </select>
                </div>
                <div class="filter-group">
                    <select id="locationFilter" class="filter-select">
                        <option value="">Të gjitha qytetet</option>
                        <option value="Prishtina">Prishtina</option>
                        <option value="Prizren">Prizren</option>
                        <option value="Peja">Peja</option>
                        <option value="Mitrovica">Mitrovica</option>
                        <option value="Gjilan">Gjilan</option>
                    </select>
                </div>
            </div>

            <div class="groups-grid" id="groupsContainer">
               
                <div class="group-card">
                    <img src="https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?w=600&h=400&fit=crop" alt="Running Club" class="group-card-image">
                    <div class="group-card-body">
                        <div class="group-card-header">
                            <h3 class="group-card-title">Running Club Prishtina</h3>
                        </div>
                        <div class="group-card-meta">
                            <span class="category-tag tag-sport">Sport</span>
                            <span class="location-badge">📍 Prishtina</span>
                        </div>
                        <p class="group-card-desc">Vrapo bashke me komunitetin. Nga fillestaret deri te profesionistet, te gjithe jane te mirepritur.</p>
                        <div class="group-card-footer">
                            <span class="members-count">👥 156 anëtarë</span>
                            <button class="btn-join" data-name="Running Club Prishtina" data-category="Sport" data-location="Prishtina" data-members="156" data-desc="Vrapo bashke me komunitetin. Nga fillestaret deri te profesionistet, te gjithe jane te mirepritur." data-image="https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?w=600&h=400&fit=crop">Shfletoni</button>
                        </div>
                    </div>
                </div>

                <div class="group-card">
                    <img src="https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?w=600&h=400&fit=crop" alt="Board Gamers" class="group-card-image">
                    <div class="group-card-body">
                        <div class="group-card-header">
                            <h3 class="group-card-title">Kosovo Board Gamers</h3>
                        </div>
                        <div class="group-card-meta">
                            <span class="category-tag tag-games">Lojëra</span>
                            <span class="location-badge">📍 Prishtina</span>
                        </div>
                        <p class="group-card-desc">Lojerat e tabeles jane pasioni yne. Nga Chess deri te Catan, bashkohu per serat e ndezura.</p>
                        <div class="group-card-footer">
                            <span class="members-count">👥 89 anëtarë</span>
                            <button class="btn-join" data-name="Kosovo Board Gamers" data-category="Lojëra" data-location="Prishtina" data-members="89" data-desc="Lojerat e tabeles jane pasioni yne. Nga Chess deri te Catan, bashkohu per serat e ndezura." data-image="https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?w=600&h=400&fit=crop">Shfletoni</button>
                        </div>
                    </div>
                </div>

                <div class="group-card">
                    <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=600&h=400&fit=crop" alt="Book Club" class="group-card-image">
                    <div class="group-card-body">
                        <div class="group-card-header">
                            <h3 class="group-card-title">Book Club Prishtina</h3>
                        </div>
                        <div class="group-card-meta">
                            <span class="category-tag tag-books">Libra</span>
                            <span class="location-badge">📍 Prishtina</span>
                        </div>
                        <p class="group-card-desc">Diskuto librat me njerez qe duan te ndajne mendimet e tyre. Bashkohu per lexime te gjalla.</p>
                        <div class="group-card-footer">
                            <span class="members-count">👥 203 anëtarë</span>
                            <button class="btn-join" data-name="Book Club Prishtina" data-category="Libra" data-location="Prishtina" data-members="203" data-desc="Diskuto librat me njerez qe duan te ndajne mendimet e tyre. Bashkohu per lexime te gjalla." data-image="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=600&h=400&fit=crop">Shfletoni</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <div id="createGroupModal" class="modal">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: white;">
                <h3 style="margin: 0; color: white;">✨ Krijo një Grup të Ri</h3>
                <button class="modal-close" onclick="toggleCreateGroupModal()" style="color: white;">&times;</button>
            </div>
            <form id="createGroupForm" onsubmit="handleCreateGroup(event)" method="POST" action="create_group.php">
                <div style="padding: 24px;">
                    <div class="form-section" style="padding: 15px 0; border-bottom: 1px solid #e2e8f0;">
                        <h4 style="margin-top: 0; margin-bottom: 15px; color: var(--primary); font-size: 16px;">Informacion Bazik</h4>
                        <div class="form-group">
                            <label for="groupName">📝 Emri i Grupit *</label>
                            <input type="text" id="groupName" name="groupName" required placeholder="p.sh. Running Club Prishtina" style="font-size: 15px; padding: 12px;">
                        </div>
                        <div class="form-group">
                            <label for="groupCategory">🏷️ Kategoria *</label>
                            <select id="groupCategory" name="groupCategory" required style="padding: 12px; font-size: 15px;">
                                <option value="">Zgjidh kategorinë</option>
                                <option value="Sport">⚽ Sport</option>
                                <option value="Kulturë">🎭 Kulturë</option>
                                <option value="Teknologji">💻 Teknologji</option>
                                <option value="Libra">📚 Libra</option>
                                <option value="Filma">🎬 Filma</option>
                                <option value="Lojëra">🎮 Lojëra</option>
                                <option value="Muzikë">🎵 Muzikë</option>
                                <option value="Tjeter">✨ Tjeter</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-section" style="padding: 15px 0; border-bottom: 1px solid #e2e8f0;">
                        <h4 style="margin-top: 0; margin-bottom: 15px; color: var(--primary); font-size: 16px;">Vendndodhja</h4>
                        <div class="form-group">
                            <label for="groupLocation">📍 Vendndodhja *</label>
                            <select id="groupLocation" name="groupLocation" required style="padding: 12px; font-size: 15px;">
                                <option value="">Zgjidh qytetin</option>
                                <option value="Prishtina">Prishtina</option>
                                <option value="Prizren">Prizren</option>
                                <option value="Peja">Peja</option>
                                <option value="Mitrovica">Mitrovica</option>
                                <option value="Gjilan">Gjilan</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-section" style="padding: 15px 0; border-bottom: 1px solid #e2e8f0;">
                        <h4 style="margin-top: 0; margin-bottom: 15px; color: var(--primary); font-size: 16px;">Përshkrimi</h4>
                        <div class="form-group">
                            <label for="groupDescription">💬 Përshkrimi *</label>
                            <textarea id="groupDescription" name="groupDescription" required placeholder="Përshkruaj qëllimin dhe aktivitetet e grupit..." rows="4" style="padding: 12px; font-size: 14px;"></textarea>
                        </div>
                    </div>

                    <div class="form-section" style="padding: 15px 0;">
                        <h4 style="margin-top: 0; margin-bottom: 15px; color: var(--primary); font-size: 16px;">Foto</h4>
                        <div class="form-group">
                            <label for="groupImage">🖼️ Foto e Grupit (URL)</label>
                            <input type="url" id="groupImage" name="groupImage" placeholder="https://example.com/photo.jpg" style="padding: 12px; font-size: 15px;">
                        </div>
                    </div>

                    <div style="display: flex; gap: 10px; padding: 15px 0;">
                        <button type="submit" class="btn-primary" style="flex: 1; padding: 14px; font-size: 16px; font-weight: 600; border-radius: 8px; border: none; cursor: pointer;">✅ Krijo Grupin</button>
                        <button type="button" onclick="toggleCreateGroupModal()" style="flex: 1; padding: 14px; font-size: 16px; font-weight: 600; border-radius: 8px; background-color: #e2e8f0; color: var(--dark); border: none; cursor: pointer;">Anulo</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
    <div id="groupDetailsModal" class="modal">
        <div class="modal-content modal-content-lg">
            <div class="modal-header">
                <h3 id="modalGroupName"></h3>
                <button class="modal-close" onclick="closeGroupDetailsModal()">&times;</button>
            </div>
            <div class="modal-body">
                <img id="modalGroupImage" src="" alt="Group" class="modal-group-image">
                <div class="group-info">
                    <div class="info-row">
                        <span class="info-label">Kategoria:</span>
                        <span id="modalGroupCategory" class="tag"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Vendndodhja:</span>
                        <span id="modalGroupLocation"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Anëtarë:</span>
                        <span id="modalGroupMembers"></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Përshkrimi:</span>
                        <p id="modalGroupDescription"></p>
                    </div>
                </div>
                <button id="modalJoinBtn" class="btn-primary modal-action-btn" onclick="handleJoinGroup()">Bashkohu me Grupin</button>
            </div>
        </div>
    </div>


    <script src="assets/js/groups.js"></script>
    <?php require_once 'includes/footer.php'; ?>
</body>
</html>
