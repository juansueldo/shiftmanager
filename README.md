<p align="center"><a href="https://github.com/juansueldo/shiftmanager" target="_blank"><img src="https://github.com/juansueldo/shiftmanager/blob/main/public/img/logo.png" width="400" alt="Laravel Logo"></a></p>

**ShiftManager** is a web application designed to efficiently manage medical appointments. Built with Laravel and a modern frontend stack, it allows users to register doctors, specialties, and patients, and to schedule appointments through an intuitive interface.

## Features

- **Doctor Management**: Create, edit, and delete doctor profiles. Assign them to one or more specialties.
- **Specialty Management**: Define and manage medical specialties.
- **Patient Management**: Register and manage patient information.
- **Appointment Scheduling**: Schedule appointments by selecting a doctor, patient, date, and time.
- **Interactive Calendar**: Visualize and manage appointments using FullCalendar.
- **Dynamic Tables**: Utilize DataTables.js for sorting and searching through records.
- **Responsive Dashboard**: Organize dashboard widgets dynamically with Gridstack.js.
- **Responsive Design**: Optimized for both desktop and mobile devices.

## Technologies Used

- **Backend**: Laravel (PHP)
- **Frontend**: HTML, CSS, JavaScript, jQuery, Bootstrap
- **Calendar & UI**: FullCalendar, DataTables.js, Gridstack.js
- **Database**: MySQL

## Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/juansueldo/shiftmanager.git
   cd shiftmanager
   ```
2. **Install dependencies**:
```bash
composer install
npm install && npm run dev
```
3. **Configure the environment**:
```bash
cp .env.example .env
php artisan key:generate
```
4. **Set up your database credentials in the .env file.**

5. **Run migrations**:
```bash
php artisan migrate
```
6. **Run seeders (required): This step initializes default data such as appointment statuses**.
```bash
php artisan db:seed
```
7. **Start the development server**:
```bash
composer run dev
```
8. **Access the application at http://127.0.0.1:8000.**

### License

This project is licensed under the [MIT License](https://opensource.org/license/MIT).
