# Surfo — Taghazout Surf Expo

Application de gestion interne pour une école de surf, développée en PHP natif avec une architecture MVC et la Programmation Orientée Objet.

---

## Arborescence du projet

```
surfo/
├── login.php            ← Page de connexion
├── register.php         ← Page d'inscription surfeur
├── dashboard.php        ← Tableau de bord admin
├── student_edit.php     ← Modifier le niveau d'un élève (admin)
├── lesson_create.php    ← Créer un cours (admin)
├── lesson_enroll.php    ← Inscrire des élèves à un cours (admin)
├── my_lessons.php       ← Agenda du surfeur connecté (client)
├── logout.php           ← Déconnexion
│
├── database.sql         ← Script SQL complet (création + seeding)
├── README.md
│
├── app/
│   ├── config/
│   │   └── config.php       ← Constantes DB
│   ├── core/
│   │   └── Database.php     ← Classe PDO Singleton
│   ├── models/
│   │   ├── User.php
│   │   ├── Student.php
│   │   └── Lesson.php
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── StudentController.php
│   │   └── LessonController.php
│   └── views/
│       ├── layouts/
│       │   ├── header.php
│       │   └── footer.php
│       ├── auth/
│       │   ├── login.php
│       │   └── register.php
│       ├── dashboard/
│       │   └── index.php
│       ├── students/
│       │   ├── edit.php
│       │   └── my_lessons.php
│       └── lessons/
│           ├── create.php
│           └── enroll.php
│
└── public/
    └── css/
        └── style.css
```

---

## Schéma de la base de données

```
users
  id | name | email | password | role (admin|client) | created_at

students
  id | user_id (FK→users) | country | level (Débutant|Intermédiaire|Avancé) | created_at

lessons
  id | title | coach | date_time | created_at

enrollments  ← table de liaison
  id | student_id (FK→students) | lesson_id (FK→lessons) | payment_status (Payé|En attente)
```

---

## Installation

1. Copier le dossier dans `xampp/htdocs/php chalenges/surfo/`
2. Démarrer Apache et MySQL dans XAMPP
3. Importer `database.sql` dans phpMyAdmin
4. Ouvrir `http://localhost/php chalenges/surfo/login.php`

---

## Comptes de test

| Rôle  | Email             | Mot de passe |
|-------|-------------------|--------------|
| Admin | admin@surfo.com   | password     |
| Client| lucas@mail.com    | password     |
| Client| sofia@mail.com    | password     |
| Client| yuki@mail.com     | password     |
| Client| omar@mail.com     | password     |
| Client| emma@mail.com     | password     |

---

## User Stories couvertes

| US  | Description                                      | Rôle   |
|-----|--------------------------------------------------|--------|
| US1 | Connexion + dashboard (élèves + cours + stat)   | Admin  |
| US2 | Créer un cours et inscrire des élèves            | Admin  |
| US3 | Modifier le niveau d'un élève                   | Admin  |
| US4 | Créer son profil surfeur (inscription)           | Client |
| US5 | Consulter ses cours + statut paiement            | Client |
| ⭐  | Stat : moyenne d'élèves par session              | Admin  |

---

## Architecture MVC

- **Model** : classes `User`, `Student`, `Lesson` avec propriétés `private` et méthodes `public`, PDO Prepared Statements
- **View** : fichiers HTML/PHP dans `app/views/`, aucune requête SQL, affichage uniquement
- **Controller** : classes dans `app/controllers/`, toute la logique métier, renvoie des tableaux de données aux vues

---

## Commits Git suggérés

```
git init
git add .
git commit -m "Initial project structure"
git add app/core/Database.php
git commit -m "Add Database PDO singleton class"
git add app/models/
git commit -m "Add User, Student and Lesson models with OOP encapsulation"
git add app/controllers/
git commit -m "Add AuthController, DashboardController, StudentController, LessonController"
git add app/views/
git commit -m "Add all views (login, register, dashboard, students, lessons)"
git add *.php
git commit -m "Add page entry points (no router — direct PHP files)"
git add public/
git commit -m "Add minimal responsive CSS"
git add database.sql README.md
git commit -m "Add SQL schema, seeding data and README"
```
