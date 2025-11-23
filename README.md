# THOUGHTS 

## Table of Contents
* [Project Description and Purpose](#project-description-and-purpose)
* [Features Implemented](#features-implemented)
* [Installation Instructions](#installation-instructions)
* [Database Setup Steps](#database-setup-steps)
* [Screenshots](#screenshots)
* [Credits](#credits)

---

## PROJECT DESCRIPTION AND PURPOSE

**Project Name:** THOUGHTS

**Description:**
Thoughts is a Threads/Twitter inspired web application. It features a modern, responsive design with dark mode support, real-time interactions, and comprehensive profile management.

**Purpose:**
This was developed as a Lab Exam output that aims to build a full-stack web application that showcases Authentication, CRUD Operations, Database Logic, and a Responsive UI.

---

## FEATURES IMPLEMENTED

### 1. User & Profile Management with Security
* **Secure Login/Register:** Built on Laravel Breeze with custom dark/purple styling. Also includes password hashing and security.
* **Session Security:** Implemented `PreventBackHistory` middleware to restrict access to authenticated pages after logging out.
* **Profile Customization:** Allows users to upload and change their profile picture and display name.
* **Tabbed Navigation on Profile:** Users can see their own thoughts (tweets) and the thoughts (tweets) they've liked on their profile dashboard.
* **Live Stats:** Automatically counts total thoughts posted and total likes received.

### 2. Tweet Management & Liking System
* **Posting:** Users can share thoughts (tweet) (max 280 chars) via a modal with a live character counter.
* **Feed:** A global homepage displaying thoughts (tweets) from all users in real-time order.
* **Edit & Delete:** Users can manage their own content. Deletion is protected by a custom confirmation modal.
* **Liking:** Users can like and unlike any thoughts (tweets) (including their own), can like a tweet one time only, like count displaying in real-time without full page refresh, and has a visual indicator if current user has liked a thought/s (tweet/s).
* **Authentication:** Only authenticated users can post and like. If a user is not yet authenticated, they can only see the homepage but cannot post and like.

### 3. UI/UX Design
* **Light/Dark Mode:** Users can choose between light mode and dark mode for the website; this uses a sun/moon icon for more clarity.
* **Responsive Design:** The web app works on both mobile and desktop layouts.

---

## INSTALLATION INSTRUCTIONS

### Prerequisites
First, you should have the following:
* **Local Server:** WAMP Server (recommended) or XAMPP
* **PHP:** Version 8.2 or higher
* **Database:** MySQL
* **Node.js & NPM:** Required to build the Tailwind CSS assets
* **Git:** To clone the repository

### Follow these steps to run the project locally:

1. **Clone the Repository**
   ```bash
   git clone https://github.com/aria-na/siddayao_exam.git
   cd siddayao_exam
2. **Install PHP Dependencies**
    ```bash
    composer install
3. **Install Frontend Dependencies**
    ```bash
    npm install
    npm run build
4. **Environment Configuration**
    Copy the exam env file: `cp .env.example .env`
    Update database in details in `.env`
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=thoughts_db
    DB_USERNAME=root
    DB_PASSWORD=
5. **Generate App Key**
    ```bash
    php artisan key:generate
6. **Link Storage (For Images)**
    ```bash
    php artisan storage:link
7. **Run the application**
    ```bash
    php artisan serve

---

## DATABASE SETUP STEPS
* **Create Database:** Create a new database named `thoughts_db` in phpMyAdmin.
* **Run Migrations:**
    ```bash
    php artisan migrate

---

## SCREENSHOTS

| Guest Homepage | Guest Like |
|:---:|:---:|
| ![Guest Homepage](guest_homepage.png) | ![Guest Like](like_modal.png) |

| Guest Create | Dark Mode |
|:---:|:---:|
| ![Guest Create](create_modal.png) | ![Dark Mode](dark_mode.png) |

| Login | Sign Up |
|:---:|:---:|
| ![Login](login.png) | ![Sign Up](sign_up.png) |

| Profile Setup | Profile |
|:---:|:---:|
| ![Profile Setup](profile_setup.png) | ![Profile](profile.png) |

| Post Limit | Create Post |
|:---:|:---:|
| ![Post Limit](post_limit.png) | ![Create Post](profile_updated.png) |

| User Homepage | Liked Thoughts |
|:---:|:---:|
| ![User Homepage](user_homepage.png) | ![Liked Thoughts](profile_thoughts_liked.png) |

| Edit Post | Delete Post |
|:---:|:---:|
| ![Edit Post](edit_post.png) | ![Delete Post](delete_confirmation.png) |

**Logout**
![logout](logout_confirmation.png)
---

## CREDITS
This project is made with Google Gemini, specifically in:
* **Full-stack Implementation:** Assisted in writing code for both the Laravel backend (Controllers, Models, Routes) and the Frontend (Blade views, Alpine.js logic).
* **UI/UX Design:** Generated Tailwind CSS classes inspired by Threads design.
* **Database Architecture:** Helped design the schema, relationships, and complex raw SQL syntax for database triggers.
* **Debugging & Refactoring:** Provided real-time troubleshooting for errors and suggestions for code optimization.