# 🏆 Mini-CTF: "RolePlay-Repeater" 

This repository hosts a small, vulnerable web application designed specifically to be solved using only the core features of **Burp Suite** (Proxy, Repeater, and Intruder). This project demonstrates proficiency in common web application penetration testing techniques like **Cookie Manipulation** and **IDOR/Parameter Enumeration**.

## 🛠️ Setup Instructions

To run this challenge, you need a local web server environment that can execute PHP (like XAMPP, MAMP, or a local PHP server).

1.  **Environment:** Ensure you have a web server running and Burp Suite Community or Professional installed.
2.  **Deployment:** Place the `index.php`, `secret_admin_dashboard.php`, and the `api/` folder into your web server's document root (e.g., `htdocs`).
3.  **Access:** Navigate to the application entry point in your browser (e.g., `http://localhost/index.php`).
4.  **Burp Setup:** Configure your browser to use **Burp Suite Proxy** (default is `127.0.0.1:8080`) to intercept all traffic.

---

## 🎯 The Challenges

Your mission is to find two hidden flags using Burp Suite:

### 🚩 Challenge 1: The Cookie Crumbles (Access Control Bypass)
* **Target:** Bypass the access control protecting the secret admin dashboard (`/secret_admin_dashboard.php`).
* **Vulnerability:** Weak session management and easily predictable cookies.
* **Hint:** Analyze the cookies set upon logging in and use **Burp Repeater**.

### 🚩 Challenge 2: Enumeration is Key (Insecure Direct Object Reference)
* **Target:** View the profile of the "Root Admin" via the API endpoint (`/api/profile.php?id=...`).
* **Vulnerability:** Predictable parameter values/IDOR.
* **Hint:** The root admin profile is usually `ID 1`. Use **Burp Intruder** to enumerate the profiles.

---

## 🔑 SOLUTION WALKTHROUGH

This section details the steps taken using Burp Suite to find both flags.

### 1. Flag 1: Cookie Manipulation with Repeater

This flag requires finding a hidden resource and modifying a session cookie to gain unauthorized access.

1.  **Login & Interception:** Log in with any credentials. Observe the response in **Burp Proxy** which sets the cookie `role=guest`.
2.  **Find the Hidden Page:** Manually browse to the hidden resource: `http://localhost/secret_admin_dashboard.php`.
3.  **Send to Repeater:** Intercept the request to `/secret_admin_dashboard.php` and send it to **Burp Repeater**.
4.  **Bypass Access:** In the Repeater request pane, change the `Cookie` header value:
    * **Original:** `Cookie: role=guest`
    * **Modified:** `Cookie: role=admin`
5.  **View Flag:** Click **Send**. The response body will contain the first flag.

**FLAG-1:** 

### 2. Flag 2: Parameter Brute-Forcing with Intruder

This flag requires iterating through possible profile IDs to find the highly privileged "Root Admin" profile.

1.  **Target Request:** From the dashboard, click "View My Profile (ID 123)". Intercept the request: `GET /api/profile.php?id=123`.
2.  **Send to Intruder:** Send this request to **Burp Intruder**.
3.  **Set Position:** In the **Positions** tab, clear all markers, highlight the `123` value, and click **Add §** to define the payload position:
    ```
    GET /api/profile.php?id=§123§ HTTP/1.1
    ```
4.  **Set Payload:** Go to the **Payloads** tab and configure:
    * **Payload Type:** `Numbers`
    * **From:** `1`
    * **To:** `10`
    * **Step:** `1`
5.  **Analyze:** Start the attack. Sort the results by the **Length** column. The request for `id=1` will have a distinctly **larger response length** because it contains the secret note/flag data.
6.  **View Flag:** Select the request with payload `1` and view the response, which is the Root Admin's profile.

**FLAG-2:** 

---

