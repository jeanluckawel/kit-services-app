# Kit Service 

> Application Laravel pour gérer les employés, clients, factures, paie, dépenses et perceptions avec un tableau de bord moderne style Kit Service.

---

## Description

Cette application permet de gérer efficacement :

- **Employés** : création, modification, consultation, import/export, contrats CDD/CDI, certificats
- **Clients** et leurs **factures** : création, modification, consultation, export PDF
- **Paie** : calculs, historique, export, bulletins
- **Dépenses & types de dépenses** : création, consultation, impression de bons
- **Perceptions** : gestion, création, historique, suppression
- **Utilisateurs & rôles** avec permissions détaillées
- Interface **Bootstrap responsive** style Kit Service

---

## Fonctionnalités principales

### Employees
- Créer, modifier, consulter, désactiver
- Import / Export Excel
- CDD / CDI, certificats
- Recherche et filtrage avancé

### Customers
- Gestion clients : créer, modifier, supprimer
- Recherche clients

### Invoices
- Créer, modifier, consulter, supprimer
- Rechercher par numéro
- Calcul automatique des totaux
- Export PDF et impression
- Lier aux clients

### Payroll
- Créer et consulter les bulletins de paie
- Historique des paiements
- Export Excel / PDF
- Calcul automatique des salaires

### Expenses & Expense Types
- Gestion des types de dépenses
- Création et suivi des dépenses
- Historique et impression des bons

### Perceptions
- Création, modification, suppression
- Historique des perceptions

### Users & Roles
- Gestion des utilisateurs et des rôles 

---

## Installation 

1. Cloner le projet :
```bash
git clone https://github.com/jeanluckawel/kit-services-app.git
cd kit-services-app

composer install
npm install
npm run dev

cp .env.example .env
php artisan key:generate

php artisan optimize:clear

php artisan migrate --seed

php artisan serve
