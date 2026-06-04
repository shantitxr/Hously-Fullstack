# Hously 🏠

Hously is a modern, full-stack real estate and rental management platform designed to streamline how users discover properties, manage personal listings, and connect directly with property owners. 

Built as a decoupled Single Page Application (SPA), Hously provides a fluid, responsive user experience backed by a secure, robust headless RESTful API[cite: 1].

---

## 🚀 Features

### 👤 Guest (Unauthenticated)
* **Discover & Browse:** Explore featured listings on the landing page with intuitive filtering options[cite: 1].
* **Detailed View:** View comprehensive property specifications, high-quality media galleries, availability dates, and amenities[cite: 1].
* **Quick Onboarding:** Simple, secure guest registration and login workflows[cite: 1].

### 🔐 Authenticated User
* **Property CRUD:** Create, read, update, and delete personal property listings with data restricted tightly to the owner via Laravel Policies[cite: 1].
* **Interactive Wishlist:** Seamlessly save and organize target properties utilizing a persistent Many-to-Many toggle interface[cite: 1].
* **Inquiry Management:** Send instant contact requests to property owners and manage incoming buyer/tenant inquiries via a dedicated inbox dashboard[cite: 1].

### 👑 Admin (Superuser)
* **Global Moderation:** Complete CRUD access over all system listings and property categories[cite: 1].
* **User Control:** Monitor and manage user accounts with administrative tools to edit, suspend, or delete accounts[cite: 1].

---

## ⚡ Non-Trivial Implementation: Multi-Step Property Wizard
Located on the `/properties/create` route, Hously implements a highly interactive, 3-step property creation wizard that relies entirely on complex client-side state[cite: 1]:
1. **Dynamic Form Layouts:** Early data selections (such as *Rent* vs. *Sale*) adaptively update the form fields and pricing logic required in later steps[cite: 1].
2. **Real-Time Financial Calculator:** Features instantaneous client-side mathematical processing using React `useMemo`[cite: 1]:
   * **For Rent:** Automatically renders the exact price per square meter ($Price / m^2$)[cite: 1].
   * **For Sale:** Dynamically calculates an estimated monthly mortgage payment using a real-time localized formula[cite: 1].
3. **Local State Persistence:** Retains data integrity seamlessly across the wizard steps before making a consolidated multi-part dispatch to the API backend[cite: 1].

---

## 🛠️ Technology Stack

### Backend
* **Framework:** Laravel (PHP 8.x) acting as a headless RESTful API[cite: 1]
* **Authentication:** Laravel Breeze + Sanctum (Secure Bearer Tokens)[cite: 1]
* **Database:** SQLite (Lightweight, efficient relational storage)[cite: 1]

### Frontend
* **Library:** React[cite: 1]
* **State Management & Caching:** TanStack Query (React Query) for smooth server-state synchronization[cite: 1]
* **Styling:** Tailwind CSS[cite: 1]
* **UI Components:** Flowbite React[cite: 1]

---

## 📊 Database Architecture

The data structure relies on a clean, relational design built across 5 main tables[cite: 1]:
* `users` - Manages credentials, profile media, and application access roles (`user`, `admin`)[cite: 1].
* `properties` - The central model housing 20 distinct attribute fields including size ($m^2$), pricing, types, and Boolean amenities[cite: 1].
* `categories` - Dynamic classification lookups for property filtering (e.g., Apartment, House, Villa)[cite: 1].
* `inquiries` - Relational logs managing contact requests with sender validation and custom communication preference enums[cite: 1].
* `property_user` (Pivot) - Standardized relationship mapper driving the custom *Wishlist* feature (Many-to-Many)[cite: 1].
