
# RABC-system

**Role Based Access Control - System**  
This project is a **Role-Based Access Control (RBAC) System**, designed to manage users, roles, and permissions efficiently. It features an intuitive and interactive user interface, ensuring seamless management of access controls in an application.

---

## Features

### 1. User Management
- Add, edit, or delete users.
- Assign roles to users dynamically.
- Toggle user status (Active/Inactive).

### 2. Role Management
- Create, edit, and delete roles.
- Assign specific permissions to roles.
- Define custom attributes for roles.

### 3. Permission Management
- Dynamic assignment of permissions (Read, Write, Delete).
- Easy-to-understand and modify permission matrix.

### 4. Security
- Validations for inputs to ensure robustness.
- Secure session management with login/logout features.

### 5. Responsive Design
- Fully responsive interface for mobile, tablet, and desktop views.
- Clean and modern UI for ease of use.

---

## Tech Stack

### Frontend
- **HTML5**, **CSS3**, **JavaScript** for structure and interactivity.
- **Bootstrap** for responsive design and styling.

### Backend
- **PHP** for server-side logic and API handling.

### Database
- **MySQL** to manage users, roles, and permissions.

### Additional Tools
- **GitHub** for version control.

---

## Setup Instructions

### 1. Clone the Repository
```bash
git clone https://github.com/sarveshpbiwalkar/RABC-system.git
cd RABC-system
```

### 2. Database Setup
- Create a database named `rbac_system` in MySQL.
- Import the `database.sql` file into your MySQL database:
  ```bash
  mysql -u [username] -p rbac_system < database.sql
  ```
  Replace `[username]` with your MySQL username.

### 3. Configure Database Connection
- Open the `db.php` file.
- Update the database connection settings:
  ```php
  $servername = "localhost";
  $username = "your-username";       // Your MySQL username
  $password = "your-password";           // Your MySQL password
  $dbname = "rbac_system";      // Database name
  ```

### 4. Deploy
- Use a local server like **XAMPP**, **WAMP**, or **MAMP** to host the project locally:
  - Place the project folder in the `htdocs` directory (for XAMPP).
  - Start the Apache and MySQL servers.
- Alternatively, deploy to a live server for public access.

### 5. Access the Application
- Open your browser and navigate to:
  ```text
  http://localhost/RABC-system
  ```
- Log in with the default admin credentials or create a new user through the database.
  username:- admin
  password:- password123
  
---

## Contact
For any queries or suggestions, feel free to reach out:

- **Author**: Sarvesh Pramod Biwalkar  
- **GitHub**: [sarveshpbiwalkar](https://github.com/sarveshpbiwalkar) 

---
