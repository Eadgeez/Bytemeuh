# Cahier des Charges - Bytemeuh.com

## 1. Présentation du Projet
**Nom du site :** Bytemeuh.com  
**Slogan :** La tech, mais en vachement cool  
**Concept :** Bytemeuh est un site d'actualité, de news et de vulgarisation technologique destiné à un large public. Le ton est décontracté, humoristique mais les informations sont sérieuses, claires et sourcées.  
Le site a pour objectif principal d'être une référence en matière de SEO (référencement naturel), tout en offrant une navigation intuitive et un contenu accessible à toutes et à tous.

---

## 2. Objectifs du Site

### Optimisation SEO
- Création et maintenance d'un **sitemap.xml** optimisé pour les moteurs de recherche.
- Configuration d'un fichier **robots.txt** permettant le bon crawl des pages du site par les moteurs de recherche.
- Mise en place des bonnes pratiques en matière de SEO : balisage HTML (**H1, H2...**), méta descriptions, URLs propres, temps de chargement optimisé, etc.
- Contenu optimisé régulièrement pour répondre aux critères des moteurs de recherche.

### Accessibilité et Expérience Utilisateur
- Faciliter la navigation à l'aide d'une barre de navigation intuitive incluant une **searchbar fonctionnelle**.
- Proposer une page listant les **derniers articles publiés**, triés par date du plus récent au plus ancien.
- Mettre à disposition des pages d'informations sur le site **Bytemeuh** (histoire, conditions d'utilisation, charte graphique, etc.).
- Permettre à l'utilisateur d'accéder au **détail d'un article**.
- Intégrer un **breadcrumb** pour que l'utilisateur puisse suivre le cours de sa navigation.

---

## 3. Arborescence du Site

### Pages principales :
- **Accueil** (bytemeuh.com)
- **Articles** (Liste des articles - Tri par date)
- **Page de recherche** (Searchbar)
- **Détail d'un article**
- **Page « À propos »**
  - Histoire de Bytemeuh
  - Charte graphique
  - Logo
  - Conditions d'utilisation
- **Contact**
- **Sitemap.xml**

---

## 4. Optimisation SEO

### Sitemap.xml
Le sitemap doit être actualisé et optimisé en fonction des pages disponibles. Voici un modèle de sitemap temporaire :

```xml
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://bytemeuh.com/</loc>
        <lastmod>2024-10-29T13:24:35+00:00</lastmod>
        <priority>1.00</priority>
    </url>
    <url>
        <loc>https://bytemeuh.com/articles</loc>
        <lastmod>2024-10-29T11:49:54+00:00</lastmod>
        <priority>0.80</priority>
    </url>
</urlset>
```
- Mise à jour automatique lors de la publication de nouveaux articles.
- Intégration de toutes les pages principales du site.

### Robots.txt
Le fichier robots.txt doit être ajusté pour optimiser le crawl :

```txt
User-agent: Googlebot
Disallow: /nogooglebot/

User-agent: 2ip.ru
Disallow: /

User-agent: *
Allow: /

Sitemap: https://www.bytemeuh.com/sitemap.xml
```

- Optimisation des restrictions pour les robots indésirables.
- Autorisation du crawl global pour les moteurs de recherche pertinents.

### SEO On-Page
- **Structure HTML** optimisée : utilisation correcte des balises titres (**H1, H2...**), attributs **alt** pour les images.
- **URLs claires et lisibles :** ex. `https://bytemeuh.com/articles/nom-de-l-article`.
- **Méta-description** et mots-clés : optimisation pour chaque page et article.
- **Performances du site :** temps de chargement réduit via compression des images, minification CSS/JS.
- **Contenu de qualité :**
  - Articles optimisés pour les mots-clés ciblés.
  - Mise à jour régulière pour maintenir la fraîcheur du contenu.
- **Mobile-friendly :**
  - Le site doit être entièrement responsive.
  - Tests via Google Mobile-Friendly Test.

---

## 5. Fonctionnalités du Site

### Barre de navigation
- Intégration d'une **searchbar** permettant de rechercher des articles et du contenu précis.

### Page des derniers articles
- Liste dynamique des articles affichés du plus récent au plus ancien.

### Pages d'informations
- Page **« À propos »** (Histoire, charte graphique, logo).
- **Conditions d'utilisation**.

### Page de détail d'un article
- Présentation complète du contenu d'un article avec un format clair et lisible.

### Breadcrumb
- Affichage d'un **fil d'Ariane** pour faciliter la navigation de l'utilisateur.

### Optimisation SEO
- Robots.txt et sitemap.xml dynamiques.

### Performance
- Temps de chargement rapide.
- Compatibilité sur tous les navigateurs et appareils.

---

## 6. Contraintes Techniques

### Langages et outils
- **Front-end :** HTML5, CSS3, JavaScript.
- **Framework CSS :** Tailwind CSS.
- **Back-end :** Node.js avec Express.js.
- **Base de données :** JSON (organisé pour minimiser les failles de sécurité).
- **Serveur :** NGINX (pour l'hébergement).

### SEO
- Respect des meilleures pratiques **Google SEO**.
- Audit SEO régulier (**Google Search Console**, outils tiers comme SEMRush ou Ahrefs).

### Responsive Design
- Site adapté à toutes les tailles d'écran.

### Sécurité
- **HTTPS obligatoire**.
- Protection contre les bots et attaques courantes.

---

## 7. Livraison et Suivi

### Phases de développement
1. **Phase 1 :** Conception de l'arborescence et de l'interface utilisateur.
2. **Phase 2 :** Développement du back-end (Express.js, gestion des articles en JSON).
3. **Phase 3 :** Intégration des bonnes pratiques SEO.
4. **Phase 4 :** Tests d'optimisation et déploiement sur serveur NGINX.

### Outils de suivi
- **Google Analytics** (analyse de trafic).
- **Google Search Console** (suivi SEO).

### Maintenance
- Mise à jour régulière des contenus et vérification des performances SEO.

---

## 8. Annexes

### Exemple d'arborescence simplifiée
```
/ (Accueil)
/articles
/search
/article/nom-de-l-article
/a-propos
/conditions-utilisation
/contact
/sitemap.xml
