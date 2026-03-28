# CMS Backend Implementation Plan

We are implementing a Pure PHP backend to manage the frontend and admin dashboard. 

## Proposed Database Schema 

We will use MySQL with the following schema:

```sql
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL, -- Will store password_hash()
  `email` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `projects` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(150) NOT NULL,
  `subtitle` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `challenge_content` TEXT, -- Detailed HTML/Text article for project detail page
  `thumbnail_image` VARCHAR(255),
  `detail_image` VARCHAR(255),
  `status` ENUM('Live', 'Staging', 'Draft') DEFAULT 'Draft',
  `technologies` VARCHAR(255), -- Comma separated or JSON to store tech stack e.g., "React,Node.js"
  `demo_link` VARCHAR(255),
  `repo_link` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `project_objectives` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `project_id` INT NOT NULL,
  `objective` VARCHAR(255) NOT NULL,
  FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE
);

CREATE TABLE `contacts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `full_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `inquiry_type` VARCHAR(50) NOT NULL,
  `message` TEXT NOT NULL,
  `is_read` BOOLEAN DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Proposed Changes

We will create and modify the following files:

### Database & Config
#### [NEW] `config.php`: Database connection using PHP PDO.
#### [NEW] `schema.sql`: Contains the SQL dump file to easily import to MySQL/PhpMyAdmin.

### Authentication
#### [NEW] `login.php`: Admin login page (verifies against the `users` table).
#### [NEW] `logout.php`: Destroys the admin session.
#### [NEW] `auth.php`: A helper included on all protected admin pages to ensure the user is logged in.

### Admin Dashboard (CMS)
#### [NEW] `admin_dashboard.php`: The main dashboard (converted from [cms_admin.html](file:///c:/xampp/htdocs/php%20chalenges/stitch/cms_admin.html)) listing projects, showing stats.
#### [NEW] `admin_project_add.php`: Form to insert new projects into the DB.
#### [NEW] `admin_project_edit.php`: Form to edit existing projects.
#### [NEW] `admin_project_delete.php`: Script to handle project deletion.
#### [NEW] `admin_contacts.php`: Admin view to list all contact form submissions.

### Frontend Pages
#### [MODIFY] `index.php` (from [index.html](file:///c:/xampp/htdocs/php%20chalenges/stitch/index.html)): Dynamically fetches Live projects from DB and displays them correctly.
#### [MODIFY] `project_detail.php` (from `project detail.html`): Uses `?id=X` in URL to fetch specific project details, objectives, and tech stack.
#### [MODIFY] `contact.php` (from [contact.html](file:///c:/xampp/htdocs/php%20chalenges/stitch/contact.html)): Handles the Contact form layout securely.
#### [NEW] `contact_process.php`: Backend script that receives POST data from `contact.php`, validates it, and saves it to the `contacts` table.

## User Review Required
Does the DB Schema look good to you? Do you want to include any specific plugins for image uploading (like moving uploaded files directly to a folder vs using URLs), or the user password creation?

## Verification Plan

### Automated/Manual Tests
- **Setup Testing**: I will establish the DB via a small setup script that seeds the user table with an admin account (admin / password).
- **Authentication Test**: Verify that trying to access `admin_dashboard.php` redirects to `login.php`. Logging in with the seeded credentials will successfully load the dashboard.
- **CRUD Validation**: I will use the browser subagent or curl to interact with the Add Project page, verify that it inserts into the Database.
- **Frontend Validation**: Ensure `index.php` shows exactly the data we inserted in the DB.
- **Contact Form**: Post a test message through `contact.php` and verify it lands in the Database.
