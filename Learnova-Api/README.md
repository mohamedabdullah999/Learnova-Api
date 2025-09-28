# Learnova API

This is the **Learnova API**, built with **Laravel 12**.  
It includes user authentication (JWT), user profile management, and image handling.

---

## 🚀 Installation & Setup

Follow these steps to run the API locally:

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/Learnova-Api.git
cd Learnova-Api
```

### 2. Install Dependencies (If you didn't install Laravel 12 yet)

```bash
composer install
npm install
```

### 3. Create Environment File

```bash
cp .env.example .env
```

Update the `.env` file with your local database credentials, e.g.:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=learnova
DB_USERNAME=root
DB_PASSWORD=
```

Also configure the storage link:

```
APP_URL=http://localhost:8000
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Create Storage Link

```bash
php artisan storage:link
```

### 7. Start the Development Server

```bash
composer run dev
```

The API will now be available at:  
👉 `http://localhost:8000/api`

---

## 🔑 Authentication (JWT)

This project uses **JWT (JSON Web Token)** for authentication.  
Once you log in or register, you will receive a **token** like this:

```json
{
    "access_token": "your.jwt.token.here",
    "token_type": "bearer",
    "expires_in": 3600
}
```

### How to Use the Token

For every **protected request**, add this header in **Postman** or your frontend app:

```
Authorization: Bearer your.jwt.token.here
```

---

## 👤 User Profile & Avatar

-   You can update your profile data via the **Profile API**.
-   You can upload an avatar (image).

Uploaded images are stored in:

```
storage/app/public/users/
```

And are accessible via URL:

```
http://localhost:8000/storage/users/your_image.png
```

### Example Response

```json
{
    "message": "Avatar updated successfully",
    "user": {
        "id": 1,
        "name": "Mohamed",
        "email": "mohamed@example.com",
        "img": "http://localhost:8000/storage/users/abc123.png"
    }
}
```

So you can **directly use `img` link** in your frontend without any extra handling.

---

## 📡 Example API Endpoints

-   **Register**: `POST /api/register`
-   **Login**: `POST /api/login`
-   **Profile**: `GET /api/profile` (requires Bearer token)
-   **Update Profile**: `POST /api/user/profile/`
-   **Update Avatar**: `POST /api/user/avatar`

---

## ✅ Notes

-   Make sure you always pass the JWT token in the header for protected routes.
-   Image URLs returned in responses are already usable in your frontend.

---

## 🤝 Contributing

Feel free to fork this repo and submit pull requests with improvements.

---

## 📝 License

This project is licensed under the MIT License.
