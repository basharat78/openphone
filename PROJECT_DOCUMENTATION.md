# OpenPhone Quality Control (QC) Integration

## Overview
This project is a specialized Quality Control (QC) platform built on top of Laravel, designed to integrate with the **OpenPhone API**. It allows QC Specialists to monitor, listen to, and score call recordings to ensure high standards of communication and professionalism.

## Tech Stack
- **Backend**: Laravel 12.0 (PHP)
- **Frontend**: Tailwind CSS, Blade Templates, Vite
- **Database**: MySQL / MariaDB
- **API Integration**: OpenPhone API (v2)

---

## Core Features

### 1. QC Dashboard
A modern, dark-themed analytics landing page for QC Specialists.
- **Real-time Stats**: Track total captured calls, reviewed sessions, and pending reviews.
- **Global Quality Metric**: Calculates the average quality score across all reviewed interactions.
- **Recent Activity**: Quick view of the latest five scoring sessions.

### 2. OpenPhone Synchronisation
Automated and manual syncing of call data from OpenPhone.
- **Artisan Command**: `php artisan calls:import` pulls recent conversations and recordings.
- **Dynamic Mapping**: Automatically maps OpenPhone User IDs to internal Dispatcher records.
- **Conflict Management**: Uses `updateOrCreate` to ensure records (recordings, durations) stay up-to-date without duplication.

### 3. Interaction Scoring
A detailed review interface for individual calls.
- **Audio Integration**: Direct playback of call recordings within the browser.
- **Scoring Metrics**:
    - **Communication**: Clarity and effectiveness.
    - **Confidence**: Tone and authority.
    - **Professionalism**: Adherence to brand standards.
    - **Closing**: Proper session termination.
- **Remarks**: Qualitative feedback for dispatchers.
- **Locking Mechanism**: Scores can be finalized and locked to prevent post-review modification.

### 4. Role-Based Access Control
Custom authentication flow to separate QC operations from general admin/user tasks.
- **User Types**: Introduction of the `qc` user type in the `users` table.
- **Auto-Redirection**: Upon login, QC users are automatically routed to the `/qc/dashboard`.
- **Middleware Protection**: Routes are guarded by `auth` and `user.type:qc` middleware.

---

## Technical Architecture

### Models & Relationships
- **Dispatcher**: Represents the person receiving/making calls.
    - `hasMany(Call)`
- **Call**: Represents an individual OpenPhone interaction.
    - `belongsTo(Dispatcher)`
    - `hasOne(QcScore)`
- **QcScore**: Stores the evaluation results.
    - `belongsTo(Call)`
    - `belongsTo(User)` (QC Agent)

### Key Services
- **OpenPhoneService**: Handles all HTTP communication with the OpenPhone API. Includes support for pagination, rate limit management, and data transformation.

---

## Setup & Configuration

### Environment Variables
The following keys must be added to your `.env` file:
```env
OPENPHONE_API_KEY=your_api_key_here
OPENPHONE_BASE_URL=https://api.openphone.com/v1
```

### Initial Setup
1. Run migrations: `php artisan migrate`
2. Compile assets: `npm install && npm run build`
3. Seed/Create a QC user:
   ```php
   User::create([
       'name' => 'QC Specialist',
       'email' => 'qc@example.com',
       'password' => bcrypt('password'),
       'user_type' => 'qc'
   ]);
   ```
4. Initial call sync: `php artisan calls:import`

---

## User Interface (UI) Design
The QC Panel utilizes a **Dark Theme** designed for long-form monitoring.
- **Aesthetic**: Light Black background (`#111827`) with charcoal cards (`#1f2937`).
- **Glassmorphism**: Navigation bars utilize background blur and transparency for a premium look.
- **Interactive Elements**: Custom range sliders for scoring and glowing status badges for readability.

---

## Developer Guide
- **Routes**: Defined in `routes/web.php` under the `qc.` name prefix.
- **Controllers**: Main logic resides in `App\Http\Controllers\Qc\CallController`.
- **Views**: Located in `resources/views/qc/`.
- **Layouts**: Uses `x-app-layout` with a conditional `layouts.qc-navigation` inclusion.
