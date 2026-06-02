# 🎓 University Management Portal

A role-based university management system built with PHP and MySQL, designed and developed as a database course project. This portal provides dedicated dashboards for students and faculty, demonstrating advanced database concepts like complex table joins, foreign key relationships, and dynamic prerequisite checking.

## ✨ Features

### 👨‍🎓 Student Portal
* **Student Profile:** View personal academic details including Name, ID, Email, Department, and CGPA[cite: 13].
* **Smart Course Advising:** An intelligent enrollment system that fetches available courses and checks the database for prerequisites[cite: 15]. Courses are dynamically locked if the student has not passed the required prerequisite (verifying that the previous grade is not 'F')[cite: 15]. Successful selections are processed and saved for upcoming semesters (e.g., Summer2025)[cite: 14].
* **Learning Resources:** Access and download course materials, slides, and books[cite: 11]. The system uses database joins to display the course code, resource description, and the uploading faculty member's name in a single view[cite: 11].
* **Feedback & Complaints:** A dedicated portal for students to submit course evaluations (rating 1-5 with comments) and lodge general administrative complaints, which are stored with a default 'Pending' status[cite: 12].
* **Academic Results:** View semester-wise grades and course performance[cite: 10].
* **Club Management:** Browse available university clubs, join, and leave with real-time database updates[cite: 4].

### 👨‍🏫 Faculty Portal
* **Faculty Profile:** View faculty details, including department and office room assignment[cite: 2].
* **Grade Submission:** Submit and update student grades (A to F) for assigned courses[cite: 6].
* **Resource Management:** Upload course materials and share external links (like Google Drive or PDFs) directly with students enrolled in their specific courses[cite: 7].

## 🛠️ Tech Stack
* **Frontend:** HTML5, Custom CSS (Classic University Theme)[cite: 3]
* **Backend:** PHP (Session-based authentication and routing)[cite: 1, 5, 9]
* **Database:** MySQL (Demonstrates complex queries, joins, and conditional logic)[cite: 11, 15]
* **Environment:** XAMPP (Apache + MariaDB/MySQL)

