<div align="center">

<a href="https://montly.space">
  <img src="assets/github-hero.svg" alt="Montly LMS — Unified Academic LMS & School ERP" width="100%" />
</a>

<br />

<a href="https://montly.space">
  <img src="https://readme-typing-svg.demolab.com?font=JetBrains+Mono&weight=600&size=18&duration=3200&pause=1000&color=1F4DFF&center=true&vCenter=true&width=820&lines=Academic+Learning+Management+System+%2B+School+ERP;Hierarchical+Control%3A+Years+%E2%86%92+Grades+%E2%86%92+Sections+%E2%86%92+Classrooms;Conflict-Free+Schedule+Builder+%26+Native+Jitsi+Meet+Rooms;Telegram+Bot+%2B+Resend+API+Omnichannel+Notifications" alt="Montly LMS Highlights" />
</a>

<p align="center">
  <a href="https://montly.space"><img src="https://img.shields.io/badge/Production-montly.space-1F4DFF?style=for-the-badge&logo=googlechrome&logoColor=white" alt="Website"></a>
  <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.1+">
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/Filament-3.2-FBBF24?style=for-the-badge&logo=laravel&logoColor=black" alt="FilamentPHP">
  <img src="https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/PWA-Ready-5A0FC8?style=for-the-badge&logo=pwa&logoColor=white" alt="PWA">
</p>

<p align="center">
  <a href="https://montly.space"><strong>Live Platform</strong></a> ·
  <a href="#architecture--modules"><strong>Architecture</strong></a> ·
  <a href="#role-based-access-control-rbac"><strong>RBAC Matrix</strong></a> ·
  <a href="#repository-structure"><strong>Directory Structure</strong></a> ·
  <a href="https://heycriss.dev/montly"><strong>HeyCriss Labs</strong></a>
</p>

</div>

---

## Overview

**Montly LMS** combines a **Learning Management System (LMS)** with an institutional **School ERP**. It centralizes academic administration, conflict-free schedule generation, live virtual classrooms, grading workflows, and omnichannel alerts across administrators, teachers, students, and parents/guardians in real time.

> **Resumen en Español:** **Montly LMS** fusiona una plataforma educativa tipo LMS con un ERP escolar moderno para centralizar horarios, evaluaciones, aulas virtuales con Jitsi Meet y alertas omnicanal (Telegram Bot y Resend API) bajo un control de acceso estricto basado en roles (RBAC).

<br />

<div align="center">
  <img src="assets/github-features-bento.svg" alt="Montly LMS Architecture & Capabilities" width="100%" />
</div>

---

## Architecture & Modules

### 1. Institutional Analytics & Hierarchical ERP
- **Visual Dashboards:** Real-time metrics for academic performance, attendance, and grading distribution built on FilamentPHP.
- **Conflict-Free Schedule Builder:** Automated overlap detection across teachers, classrooms, and sections (`App\Models\ScheduleSlot::hasConflict()`), with branded PNG export.
- **Hierarchical Data Model:** Adapts to any school structure (`School Years → Grades → Sections → Classrooms → Subjects`).

### 2. Virtual Learning Environment
- **Native Jitsi Meet Classrooms:** Role-gated live and scheduled video sessions (`App\Services\JitsiClassroomService`).
- **Courses & Evaluations:** Rich-text syllabus, availability windows, assignment submissions, grading rubrics, and audit history.
- **Parent / Guardian Portal:** Read-only real-time view covering student attendance, grades, pending tasks, and school calendar events.

### 3. Omnichannel Automation & Infrastructure
- **Instant Alerts:** Automated notifications dispatched via **Telegram Bot** (`App\Services\OmnichannelNotifier`) and transactional emails via **Resend API**.
- **Cloud & Local Storage:** Automated backups and media storage compatible with S3-compliant buckets or local disks.
- **Progressive Web App (PWA):** Installable mobile and desktop experience (`public/manifest.json`).

---

## Role-Based Access Control (RBAC)

Montly enforces strict role isolation (`App\Enums\RoleType`) across every route and Filament resource:

| Role | Access Level | Primary Responsibilities |
| :--- | :---: | :--- |
| **Administrator** (`admin`) | `Full` | ERP configuration, academic hierarchy, global reports, and user management. |
| **Teacher** (`teacher`) | `Moderate` | Subject management, grading, assignment creation, and Jitsi classroom moderation. |
| **Student** (`student`) | `Basic` | Course material access, assignment uploads, grade tracking, and live classes. |
| **Parent / Guardian** (`guardian`) | `Read-Only` | Real-time monitoring of student progress, grades, and institutional calendar. |
| **Alumni** (`alumni`) | `Historical` | Read access to historical academic records and graduation certificates. |
| **Support** (`support`) | `Technical` | System activity monitoring, audit log inspection, and incident resolution. |

---

## System Flow

```mermaid
flowchart LR
    subgraph ERP["Institutional ERP Core (Laravel + MySQL)"]
        HIER["Hierarchy Engine<br/>Years · Grades · Sections"]
        SCHED["ScheduleSlot Model<br/>Conflict Validation + PNG"]
        RBAC["RBAC Policy Layer<br/>6 Institutional Roles"]
    end

    subgraph VLE["Virtual Learning Environment"]
        FILA["FilamentPHP 3 Panels<br/>Admin · Teacher · Student · Parent"]
        JITSI["JitsiClassroomService<br/>Live & Scheduled Rooms"]
    end

    subgraph NOTIF["Omnichannel Delivery"]
        TG["Telegram Bot API<br/>Instant Alerts"]
        RESEND["Resend Email API<br/>Transactional Mail"]
        S3["S3 / Local Storage<br/>Automated Backups"]
    end

    HIER --> SCHED
    RBAC --> FILA
    SCHED --> FILA
    FILA --> JITSI
    FILA --> TG
    FILA --> RESEND
    ERP --> S3
```

---

## Repository Structure

```text
montly-lms/
├── app/
│   ├── Enums/
│   │   └── RoleType.php                 # 6-role RBAC enum & permission helpers
│   ├── Models/
│   │   └── ScheduleSlot.php             # Schedule model with overlap conflict detector
│   └── Services/
│       ├── JitsiClassroomService.php    # Role-gated Jitsi Meet room generator
│       └── OmnichannelNotifier.php      # Telegram Bot & Resend notification service
├── assets/
│   ├── github-hero.svg                  # Animated editorial repository hero banner
│   └── github-features-bento.svg        # Animated 6-card Bento specification grid
├── config/
│   └── montly.php                       # Hierarchy, RBAC, Jitsi, and alert settings
├── database/
│   └── migrations/
│       └── 2026_01_01_000001_create_montly_hierarchy_tables.php
├── public/
│   └── manifest.json                    # Progressive Web App (PWA) manifest
├── .env.example                         # Environment configuration template
├── composer.json                        # PHP 8.1+, Laravel 11 & FilamentPHP 3 manifest
└── LICENSE                              # GPL-2.0-or-later
```

---

## Quick Start

```bash
git clone https://github.com/heycriss/montly-lms.git
cd montly-lms
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

---

## License

Released under the **GNU General Public License v2.0 or later (`GPL-2.0-or-later`)**.

<div align="center">
  <br />
  <p>Engineered by <strong><a href="https://heycriss.dev">Cristhian (Criss) · HeyCriss Labs</a></strong> · <a href="https://montly.space"><code>montly.space</code></a></p>
</div>
