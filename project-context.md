# 📊 Admin Dashboard Architecture Context

This document outlines the shared architecture between two integrated applications — a **Crypto & Gift Card App** and a **Financial App** — that both utilize a common backend, database, and user system. This context is essential for guiding improvements to the unified admin dashboard.

---

## 🧩 System Overview

-   **Two Applications**:

    -   **Crypto & Gift Card App**: Enables users to trade cryptocurrencies and gift cards.
    -   **Financial App**: Supports financial transactions like deposit, transfer, and withdrawal.

-   **Shared Elements**:

    -   **Database**: Single database powering both applications.
    -   **Users**: Unified user authentication and management.
    -   **Admin Dashboard**: One dashboard is used to manage and monitor both systems.

---

## 🗃️ Key Database Tables & Their Usage

### 1. **Users Table**

-   Shared across both apps.
-   Stores core user information.

---

### 2. **Wallets Table**

-   Used by both apps.
-   Differentiated using the `type` field:

    -   `fiat` — Used by **Crypto App**
    -   `crypto` — Used by **Crypto App**
    -   `nuban` — Used by **Financial App**

---

### 3. **Orders Table**

-   **Used only by Crypto App**
-   Represents crypto and gift card trade orders.
-   Linked to `users`, `assets`, and corresponding `wallets`.

---

### 4. **Transactions Table**

-   **Used only by Financial App**
-   Logs all financial operations: deposits, withdrawals, and transfers.
-   Tied to `wallets`, `bank_accounts`, and `users`.

---

### 5. **Assets Table**

-   **Used only by Crypto App**
-   Represents tradable cryptocurrencies and gift cards available on the platform.

---

### 6. **Bank Accounts Table**

-   **Used only by Financial App**
-   Stores users’ linked bank details for withdrawals.

---

### 7. **Tickets & Ticket Messages Tables**

-   **Used only by Financial App**
-   Support ticket system to manage customer service issues.

---

### 8. **User Metadata Table**

-   **Shared by both apps**
-   Stores additional user-related information, preferences, or configuration data.

---

## ⚙️ Relationships Summary

| Table             | Used By       | Description                                                       |
| ----------------- | ------------- | ----------------------------------------------------------------- |
| `users`           | Both          | Core user data.                                                   |
| `wallets`         | Both          | User wallets, distinguished by `type`: `fiat`, `crypto`, `nuban`. |
| `orders`          | Crypto App    | Handles crypto and gift card trade orders.                        |
| `transactions`    | Financial App | Tracks financial deposits, withdrawals, and transfers.            |
| `assets`          | Crypto App    | All tradable crypto/gift card assets.                             |
| `bank_accounts`   | Financial App | User-linked bank accounts for withdrawals.                        |
| `tickets`         | Financial App | Customer support ticket system.                                   |
| `ticket_messages` | Financial App | Messages associated with tickets.                                 |
| `user_meta`       | Both          | Extended user information.                                        |

---

## 🧠 Admin Dashboard Considerations

To improve the admin dashboard, consider the following:

-   **Contextual Filtering**: Allow switching views between **Crypto App** and **Financial App** modes for better segmentation.
-   **Wallet Insights**: Show wallet balances and usage by `type` (`nuban`, `fiat`, `crypto`) with context-aware dashboards.
-   **Order vs Transaction Tracking**: Separate analytics panels for **Crypto Orders** and **Finance Transactions**.
-   **Unified User Profiles**: Combine user-related data (wallets, bank accounts, orders, transactions, tickets) under a single profile view.
-   **Asset Management Tools**: Admin tools for managing crypto/gift card assets (prices, availability).
-   **Support Ticket Overview**: Dedicated ticket management interface for Finance App support operations.
-   **Audit & Logs**: Activity logs should reflect context (i.e., if actions are related to crypto vs finance).
-   **Tagging/Flagging**: Tag users, orders, or transactions as belonging to one app or both, for clarity.

---

## 📌 Summary

This shared system provides flexibility and scalability by consolidating backend logic while serving distinct application use cases. By leveraging this structure, the admin dashboard can offer a powerful and unified interface with the clarity needed to manage both apps efficiently.
