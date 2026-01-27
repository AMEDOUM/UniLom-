# 🎨 Charte Graphique - UniLomé

## Palette de Couleurs Principale

### Couleur Primaire - Bleu
- **Hex:** `#2563eb` (blue-600)
- **RGB:** `rgb(37, 99, 235)`
- **Usage:** Boutons principaux, liens, icônes, cartes universitaires
- **Variantes Tailwind:**
  - `bg-blue-600` - Boutons d'action
  - `bg-blue-100` - Fond clair pour badges/icônes
  - `text-blue-600` - Texte de lien
  - `hover:bg-blue-700` - État survol

### Couleur Secondaire - Vert
- **Hex:** `#16a34a` (green-600)
- **RGB:** `rgb(22, 163, 74)`
- **Usage:** Actions de validation, confirmations, succès, formations
- **Variantes Tailwind:**
  - `bg-green-600` - Boutons de confirmation
  - `bg-green-50` - Cartes formations
  - `text-green-600` - Statuts validés
  - `hover:bg-green-100` - État survol

### Couleur Tertiaire - Violet/Pourpre
- **Hex:** `#a855f7` (purple-600)
- **RGB:** `rgb(168, 85, 247)`
- **Usage:** Formations universitaires, sections spéciales
- **Variantes Tailwind:**
  - `bg-purple-50` - Cartes formations
  - `bg-purple-100` - Fonds
  - `text-purple-600` - Icônes
  - `hover:bg-purple-100` - État survol

### Couleur d'Alerte - Rouge
- **Hex:** `#dc2626` (red-600)
- **RGB:** `rgb(220, 38, 38)`
- **Usage:** Erreurs, avertissements, délais dépassés
- **Variantes Tailwind:**
  - `bg-red-100` - Fonds d'alerte
  - `text-red-600` - Texte d'erreur

### Couleurs Neutres - Gris
- **Fond principal:** `#ffffff` (white)
- **Gris clair:** `#f3f4f6` (gray-100)
- **Gris moyen:** `#6b7280` (gray-500)
- **Gris foncé:** `#111827` (gray-900)

---

## Éléments Clés de la Charte

### 1️⃣ Boutons

#### Bouton Primaire (Bleu)
```html
<button class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">
    Action Principale
</button>
```

#### Bouton Secondaire (Vert)
```html
<button class="bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700">
    Valider / Confirmer
</button>
```

#### Bouton Désactivé
```html
<button disabled class="bg-gray-300 text-gray-500 py-2 px-4 rounded-lg cursor-not-allowed">
    Bouton Inactif
</button>
```

---

### 2️⃣ Cartes

#### Carte Université (Bleu)
```html
<div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg">
    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
        <i class="fas fa-university text-blue-600"></i>
    </div>
</div>
```

#### Carte Formation (Vert/Violet)
```html
<div class="bg-green-50 p-6 rounded-xl hover:bg-green-100 transition">
    <i class="text-green-600 text-2xl">📚</i>
    <h3>Formation</h3>
</div>
```

---

### 3️⃣ Badges & Tags

#### Badge de Validation (Vert)
```html
<span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
    ✓ Validée
</span>
```

#### Badge de Statut (Bleu)
```html
<span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded">
    Statut
</span>
```

---

### 4️⃣ Alertes & Messages

#### Alerte Succès (Vert)
```html
<div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
    ✓ Message de succès
</div>
```

#### Alerte Erreur (Rouge)
```html
<div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
    ✗ Message d'erreur
</div>
```

#### Alerte Info (Bleu)
```html
<div class="p-4 bg-blue-50 rounded-lg">
    <p class="text-sm text-blue-700">Information</p>
</div>
```

---

### 5️⃣ Icônes

Toutes les icônes utilisent **Font Awesome** avec les couleurs primaires:

```html
<!-- Icône Université (Bleu) -->
<i class="fas fa-university text-blue-600"></i>

<!-- Icône Livre (Vert/Violet) -->
<i class="fas fa-book-open text-purple-600"></i>

<!-- Icône Chapeau (Éducation) -->
<i class="fas fa-graduation-cap"></i>
```

---

### 6️⃣ Typographie

#### Titres
- **H1:** `text-3xl font-bold text-gray-900`
- **H2:** `text-2xl font-bold text-gray-900`
- **H3:** `text-lg font-bold text-gray-900`

#### Texte Normal
- **Courant:** `text-gray-600`
- **Petit:** `text-sm text-gray-600`
- **Très petit:** `text-xs text-gray-500`

---

### 7️⃣ Espacements (Padding/Margin)

- **Petit:** `p-2` / `m-2` (8px)
- **Moyen:** `p-4` / `m-4` (16px)
- **Grand:** `p-6` / `m-6` (24px)
- **Très grand:** `p-8` / `m-8` (32px)

---

### 8️⃣ Coins Arrondis

- **Cartes:** `rounded-xl` (12px)
- **Boutons:** `rounded-lg` (8px)
- **Tags:** `rounded` (4px) ou `rounded-full` (infini)

---

## 🎯 Utilisation par Section

| Section | Couleur Primaire | Icône | Exemples |
|---------|------------------|-------|----------|
| **Universités** | Bleu (#2563eb) | `fa-university` | Cartes univ., liens univ. |
| **Formations** | Vert (#16a34a) | `fa-book-open` | Cartes formations, tags |
| **Gestion Univ.** | Violet (#a855f7) | `fa-graduation-cap` | Dashboard université |
| **Admin** | Bleu (#2563eb) | `fa-cog` | Panneaux de contrôle |
| **Test Orientation** | Vert (#16a34a) | `fa-clipboard-check` | Questions, résultats |
| **Favoris** | Bleu (#2563eb) | `fa-heart` | Liste des favoris |
| **Erreurs** | Rouge (#dc2626) | `fa-exclamation` | Messages d'erreur |

---

## 📋 Règles d'Application

### ✅ À FAIRE
- Utiliser les couleurs primaires pour les CTA (Call-To-Action)
- Garder les cartes avec ombre légère
- Utiliser des transitions `transition duration-200/300`
- Appliquer les couleurs cohéremment par section
- Utiliser `hover:` pour les états interactifs

### ❌ À ÉVITER
- Mélanger trop de couleurs différentes
- Utiliser des couleurs Tailwind hors de la palette définie
- Oublier les états `hover:` et `focus:`
- Utiliser des contrastes faibles
- Appliquer des styles en ligne au lieu de Tailwind

---

## 🔧 Mise à Jour Future

Pour moderniser la charte à l'avenir, modifiez le fichier `tailwind.config.js`:

```javascript
theme: {
    extend: {
        colors: {
            primary: '#2563eb',   // Bleu
            secondary: '#16a34a', // Vert
            tertiary: '#a855f7',  // Violet
        }
    }
}
```

---

**Dernière mise à jour:** 14 janvier 2026  
**Responsable:** UniLomé Platform Team
