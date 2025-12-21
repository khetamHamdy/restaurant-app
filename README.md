# 🍽️ Smart Restaurant Management System (ERP Solution)

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)

نظام إدارة مطاعم متكامل (Full-Stack) مصمم لإدارة العمليات اليومية بكفاءة عالية. يجمع النظام بين لوحة تحكم إدارية شاملة وواجهات برمجية (API) لخدمة تطبيقات الزبائن والموظفين.

---

## 🚀 المميزات التقنية القوية (High-Level Features)

### 📊 نظام إدارة العمليات (Operations Management)
* **Multi-Branch Support:** إدارة عدة فروع للمطعم من خلال لوحة تحكم واحدة.
* **Table & Reservation System:** تتبع حالة الطاولات (متاحة، محجوزة، قيد الطلب) بشكل لحظي.
* **Advanced Ordering Workflow:** دورة حياة كاملة للطلب تبدأ من الاستلام، التحضير في المطبخ، حتى الدفع والإغلاق.

### 🔐 الإدارة والأمان (Admin & Security)
* **RBAC Security:** نظام صلاحيات دقيق (مدير، كاشير، شيف) باستخدام Middleware.
* **Financial Reporting:** نظام تقارير مالية لتتبع المبيعات، المصاريف، والأرباح.
* **Audit Logs:** تتبع كامل لجميع العمليات التي تتم داخل النظام لضمان الشفافية.

### 📱 خدمات الـ API (Mobile Ready)
* **Real-time Communication:** دعم نظام محادثات (Chat) وتواصل مباشر.
* **Digital Menu:** عرض المنتجات، التصنيفات، والمفضلات بطريقة تفاعلية.

---

## 🛠️ التقنيات المستخدمة (Tech Stack)

* **Backend:** Laravel Framework (MVC Architecture).
* **Database:** MySQL مع تصميم Database Schema متطور يدعم العلاقات المعقدة.
* **API:** RESTful API موثقة وآمنة.
* **Frontend:** Blade Templates, Bootstrap 5, JavaScript.

---

## 📂 تحليل الكنترولر (Core Controllers)

* **Admin Controllers:** إدارة الفروع، الطاولات، التقارير، والصلاحيات.
* **API Controllers:** التعامل مع طلبات الموبايل (الطلبات، السلة، المحادثات، المفضلات).
* **System Controllers:** إدارة الإعدادات، الأسئلة الشائعة، وسجلات النظام.

---

## ⚙️ تعليمات التشغيل (Installation)

1️⃣ استنساخ المستودع:
git clone https://github.com/khetamHamdy/restaurant-app.git
cd restaurant-app

2️⃣ تثبيت المكتبات:
composer install
npm install

3️⃣ تجهيز قاعدة البيانات:
- قم بإنشاء ملف .env وضبط الاتصال بقاعدة البيانات.
- تنفيذ الأوامر:
php artisan key:generate
php artisan migrate --seed
php artisan storage:link

4️⃣ التشغيل:
php artisan serve

---

## 👤 المطورة (Author)
**Eng. Khetam Hamdy**
GitHub: @khetamHamdy
LinkedIn: https://www.linkedin.com/in/khetam-hamdy-a66b96253/

⭐ إذا أعجبك المشروع، لا تنسَ دعمي بـ Star على GitHub!
