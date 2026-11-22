# 📊 RestoTVA

VAT management tool for restaurants — track revenue, expenses, and automatically compute the net VAT to declare.  
Personal full-stack project (Symfony).

## 📋 About

French restaurants juggle three VAT rates (5.5%, 10%, 20%). RestoTVA lets an owner record monthly revenue and purchases, then instantly see collected VAT, deductible VAT, and the **net VAT due** — removing manual spreadsheet work.

## 🛠️ Technologies

- **Backend:** PHP 8, Symfony 6.4, Doctrine ORM
- **Database:** MySQL
- **Frontend:** Twig, HTML/CSS

## ✨ Key Features

- Revenue entry split by VAT rate (5.5% / 10% / 20%) + tips
- Expense entry with deductible VAT
- Monthly dashboard: turnover (incl./excl. tax), collected VAT per rate, deductible VAT, **net VAT due**, total tips
- Filter by month and year
- Multi-user: each account sees only its own data

## 🔐 Security

- Authentication with hashed passwords
- Data isolated per user
- Ownership verification before deletion
- CSRF protection on forms and delete actions

## 🚀 Installation

```bash
git clone https://github.com/Libanama/resto_tva.git
cd resto_tva

composer install

# Configure environment
cp .env .env.local
# Set your DATABASE_URL and a new APP_SECRET in .env.local

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

symfony server:start
```

## 👤 Author

**Libana**  
Full-stack web developer (DWWM) | Career transition from hospitality to tech