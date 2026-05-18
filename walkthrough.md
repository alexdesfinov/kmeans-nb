# Re-Skinning FADEL — Walkthrough

Berikut ringkasan semua perubahan visual yang telah dilakukan pada aplikasi FADEL.

> [!IMPORTANT]
> **Tidak ada perubahan PHP logic.** Semua algoritma K-Means, Naive Bayes, database queries, dan POST handlers tetap utuh. Perubahan hanya pada CSS, HTML layout, dan branding.

---

## 1. Landing Page (index.php) — Redesign Total

Landing page lama yang minimal diganti dengan 4 section modern:

### Hero Section
Dark gradient hero dengan glassmorphism stats card yang menampilkan info sistem (4 cluster, 20 pertanyaan, 6 fitur).

![Landing Hero](C:/Users/alexd/.gemini/antigravity/brain/cdb18c9f-e977-4e4b-afcf-e668a61b8d4f/landing_hero.png)

### Features & Cara Kerja
4 feature cards + 3 langkah cara kerja dengan scroll animations.

![Landing Features](C:/Users/alexd/.gemini/antigravity/brain/cdb18c9f-e977-4e4b-afcf-e668a61b8d4f/landing_features.png)

### Login Form Embedded
Form login langsung di halaman + info "Akses Portal FADEL".

![Landing Login](C:/Users/alexd/.gemini/antigravity/brain/cdb18c9f-e977-4e4b-afcf-e668a61b8d4f/landing_login.png)

---

## 2. Portal Login & Register — Split-Screen Design

![Portal Login](C:/Users/alexd/.gemini/antigravity/brain/cdb18c9f-e977-4e4b-afcf-e668a61b8d4f/portal_login.png)

![Portal Register](C:/Users/alexd/.gemini/antigravity/brain/cdb18c9f-e977-4e4b-afcf-e668a61b8d4f/portal_register.png)

---

## 3. Dashboard — Welcome Banner + Menu Cards

![Dashboard](C:/Users/alexd/.gemini/antigravity/brain/cdb18c9f-e977-4e4b-afcf-e668a61b8d4f/portal_dashboard.png)

---

## Files Changed

| File | Perubahan |
|------|-----------|
| `portal/config/assets.php` | TITLE → "FADEL", Google Fonts Inter |
| `portal/assets/css/style.css` | **Overhaul total** — design tokens, animations, sidenav, cards, tables, cluster badges |
| `portal/layout/head.php` | Meta description, font link |
| `portal/layout/nav.php` | Gradient logo, section headers (Data/Analisis/Lainnya), hover effects |
| `portal/layout/header.php` | Breadcrumb separator `›`, user avatar pill |
| `portal/layout/footer.php` | © FADEL — Antigravity |
| `portal/layout/script.php` | SweetAlert color consistency |
| `portal/module/dashboard.php` | Welcome banner + data-driven menu cards with descriptions |
| `index.php` | **Redesign total** — 4 section landing page |
| `portal/index.php` | Split-screen login with gradient visual panel |
| `portal/registration.php` | Consistent split-screen register |
| `portal/module/dataTraining/index.php` | Icon header, data count badge, improved table |
| `portal/module/dataTesting/index.php` | Icon header, data count badge, improved table |
| `portal/module/hasil_tes/index.php` | Color-coded cluster badges (Parah/Sedang/Ringan/Normal) |
| `portal/module/hasil_tes_naive/index.php` | Prediction badges with color coding |
| `portal/module/uploadDataset/index.php` | Styled upload zone with icon header |
| `portal/module/user/index.php` | Icon header, level badges (Admin/User colors) |

## Design System

```
Primary:    #cb0c9f (Pink-Magenta)
Secondary:  #627594
Dark:       #344767
Success:    #82d616
Warning:    #fbcf33
Danger:     #ea0606
Info:       #17c1e8
Font:       Inter (Google Fonts)
Radius:     16px (cards), 10px (buttons/inputs)
```

## Verification

| Halaman | Status |
|---------|--------|
| Landing Page (4 sections) | ✅ Verified |
| Portal Login | ✅ Verified |
| Portal Register | ✅ Verified |
| Dashboard + Sidebar | ✅ Verified |
| SweetAlert Styling | ✅ CSS Applied |
| Module Views | ✅ CSS Applied |
