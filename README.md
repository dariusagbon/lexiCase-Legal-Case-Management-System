# LexiCase - Legal Case Management System

A comprehensive, modern web application built with Laravel for managing legal cases, lawyers, and client information. Designed for law firms, attorneys, and legal professionals to streamline case management workflows.

## 📋 Table of Contents

- [Features](#features)
- [How It Works](#how-it-works)
- [Technology Stack](#technology-stack)
- [Installation](#installation)
- [Usage](#usage)
- [Database Structure](#database-structure)
- [API Endpoints](#api-endpoints)
- [Contributing](#contributing)
- [License](#license)

## ✨ Features

### 🔐 Authentication & Security
- User registration and login system
- Secure password hashing and session management
- Protected routes with middleware authentication
- Email verification for account security

### 👨‍⚖️ Lawyer Management
- Complete CRUD operations for lawyer profiles
- Store lawyer information (name, email, phone, specialization)
- Track years of experience
- Associate lawyers with their cases

### 📁 Case Management
- Full case lifecycle management (Create, Read, Update, Delete)
- Case details including:
  - Case number and type
  - Client information
  - Filing dates and deadlines
  - Case status tracking (open, pending, closed)
  - Detailed case descriptions
- Automatic date casting for proper date handling

### 📊 Dashboard & Analytics
- Real-time statistics dashboard
- Case status overview (active, pending, closed cases)
- Lawyer workload tracking
- Recent case activity feed
- Client count and system metrics

### 🎨 Modern User Interface
- Responsive design with Tailwind CSS
- Clean, professional interface suitable for legal professionals
- Mobile-friendly responsive layout
- Intuitive navigation and user experience

### 🌐 Public Showcase
- Public welcome page displaying system capabilities
- Showcase of top lawyers and resolved cases
- Statistics display for marketing purposes
- Call-to-action sections for user registration

## 🔄 How It Works

### System Architecture

LexiCase follows the **MVC (Model-View-Controller)** pattern implemented in Laravel:

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Controllers   │    │     Models      │    │     Views       │
│                 │    │                 │    │                 │
│ - Dashboard     │◄──►│ - LegalCase     │◄──►│ - dashboard     │
│ - Case          │    │ - Lawyer        │    │ - case/*        │
│ - Lawyer        │    │ - User          │    │ - lawyers/*     │
│ - Auth          │    │                 │    │ - welcome       │
└─────────────────┘    └─────────────────┘    └─────────────────┘
       │                       │                       │
       └───────────────────────┼───────────────────────┘
                               │
                    ┌─────────────────┐
                    │   Database      │
                    │                 │
                    │ - cases         │
                    │ - lawyers       │
                    │ - users         │
                    │ - migrations    │
                    └─────────────────┘
```

### Data Flow

1. **User Authentication**: Users register/login through Laravel's built-in authentication system
2. **Dashboard Access**: Authenticated users access the main dashboard with statistics
3. **Case Management**: Users can create, view, edit, and delete legal cases
4. **Lawyer Management**: System administrators can manage lawyer profiles
5. **Public Access**: Non-authenticated users can view the welcome page with system showcase

### Key Workflows

#### Case Creation Workflow
```
User Login → Dashboard → Create Case → Select Lawyer → Enter Details → Save → Redirect to Case List
```

#### Lawyer Assignment Workflow
```
Create Lawyer Profile → Create Case → Assign Lawyer → Update Case Status → Track Progress
```

## 🛠 Technology Stack

### Backend
- **Laravel 11.x** - PHP web framework
- **PHP 8.2+** - Server-side scripting
- **MySQL/SQLite** - Database management

### Frontend
- **Blade Templates** - Laravel's templating engine
- **Tailwind CSS** - Utility-first CSS framework
- **Alpine.js** - Lightweight JavaScript framework (if needed)
- **Vite** - Modern build tool for asset compilation

### Development Tools
- **Composer** - PHP dependency management
- **NPM** - Node.js package management
- **Pest** - PHP testing framework
- **Laravel Pint** - Code style fixer

## 🚀 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL or SQLite database

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd Final_Project
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   # Configure your database in .env file
   php artisan migrate
   php artisan db:seed  # If seeders are available
   ```

6. **Build assets**
   ```bash
   npm run build
   # or for development
   npm run dev
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

8. **Access the application**
   - Open `http://localhost:8000` in your browser
   - Register a new account or login

## 📖 Usage

### For Legal Professionals

1. **Registration**: Create an account with your professional details
2. **Dashboard Overview**: View case statistics and recent activity
3. **Managing Cases**:
   - Create new cases with client information
   - Assign lawyers to cases
   - Update case status and details
   - Track filing dates and deadlines
4. **Lawyer Directory**: View and manage lawyer profiles

### For Administrators

1. **Lawyer Management**: Add, edit, and remove lawyer profiles
2. **System Monitoring**: Track overall system usage and statistics
3. **Case Oversight**: Monitor all cases across the system

### Public Access

- Visit the homepage to see system capabilities
- View showcased lawyers and resolved cases
- Register for full access to case management features

## 🗄 Database Structure

### Tables Overview

#### `users`
- Standard Laravel authentication table
- Stores user credentials and profile information

#### `lawyers`
```sql
- id (Primary Key)
- name (String)
- email (String, Unique)
- phone (String)
- specialization (String)
- experience_years (Integer)
- created_at, updated_at (Timestamps)
```

#### `cases`
```sql
- id (Primary Key)
- lawyer_id (Foreign Key → lawyers.id)
- client_name (String)
- case_number (String, Unique)
- description (Text)
- status (Enum: open, pending, closed)
- case_type (String)
- filing_date (Date)
- created_at, updated_at (Timestamps)
```

### Relationships

- **Lawyer → Cases**: One-to-Many (A lawyer can have multiple cases)
- **Case → Lawyer**: Many-to-One (A case belongs to one lawyer)
- **User Authentication**: Standard Laravel user system

## 🔗 API Endpoints

### Authentication Routes
- `GET /login` - Login page
- `POST /login` - Process login
- `GET /register` - Registration page
- `POST /register` - Process registration
- `POST /logout` - Logout

### Protected Routes (Require Authentication)
- `GET /dashboard` - Main dashboard
- `GET /cases` - List all cases
- `GET /cases/create` - Create case form
- `POST /cases` - Store new case
- `GET /cases/{case}` - Show specific case
- `GET /cases/{case}/edit` - Edit case form
- `PUT /cases/{case}` - Update case
- `DELETE /cases/{case}` - Delete case

- `GET /lawyers` - List all lawyers
- `GET /lawyers/create` - Create lawyer form
- `POST /lawyers` - Store new lawyer
- `GET /lawyers/{lawyer}` - Show specific lawyer
- `GET /lawyers/{lawyer}/edit` - Edit lawyer form
- `PUT /lawyers/{lawyer}` - Update lawyer
- `DELETE /lawyers/{lawyer}` - Delete lawyer

### Public Routes
- `GET /` - Welcome page with system showcase

## 🤝 Contributing

We welcome contributions to LexiCase! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines

- Follow PSR-12 coding standards
- Use Laravel Pint for code formatting
- Write tests for new features
- Update documentation as needed
- Ensure all tests pass before submitting PR

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

**Built with ❤️ using Laravel**

*Empowering legal professionals with modern technology*
#   l e x i C a s e - L e g a l - C a s e - M a n a g e m e n t - S y s t e m  
 