# 💼 API Challenge – Laravel & PHP

This repository contains the implementation of a backend service for a customer billing system, developed as part of a hiring process.

## 🚀 Stack

- **PHP 8.4**
- **Laravel 12**
- **MySQL**
- **RESTful API**

---

## 🎯 Objective

Build a RESTful API that allows the management of:

- Customers
- Bills

The system is designed to allow external partners to create and manage billing requests for their previously registered clients.

---

## 📋 Requirements

### 🧾 Customers

Each customer has:

- Full name
- CPF or CNPJ (Tax ID)
- E-mail

**Constraints:**
- `email` and `tax_id` (CPF/CNPJ) must be unique.
- API must support creation and listing of customers.

### 💸 Bills (Charges)

Each charge must include:

- `customer_id` (required, must exist)
- `amount` (positive number, max 2 decimal places)
- `due_date` (must not be in the past)
- `description`

**Additional Requirements:**

- When a charge is created, a notification log must be generated using `Log::info()`.
- A history of all notifications must be saved to a dedicated table.

---

## 📡 API Endpoints

### Customers

#### `GET /customers`

Returns a list of all registered customers.

**Example response:**
```json
[
    {
        "id": 1,
        "name": "Letha Nader",
        "tax_id": "91835871954",
        "email": "bertha48@example.net",
        "created_at": "2025-07-04T12:38:40.000000Z",
        "updated_at": "2025-07-04T12:38:40.000000Z"
    },
    {
        "id": 2,
        "name": "Prof. Arturo Cruickshank",
        "tax_id": "80719908094",
        "email": "hegmann.hollie@example.org",
        "created_at": "2025-07-04T12:38:40.000000Z",
        "updated_at": "2025-07-04T12:38:40.000000Z"
    },
    {
        "id": 3,
        "name": "Mrs. Ottilie Watsica",
        "tax_id": "30842087432",
        "email": "xbosco@example.net",
        "created_at": "2025-07-04T12:38:40.000000Z",
        "updated_at": "2025-07-04T12:38:40.000000Z"
    }
]
```

#### `GET /customers/{id}/bills`

Returns the sum of a customer bills in the selected month

**Example response:**
```json
{
    "customer": {
        "id": 1,
        "name": "Letha Nader",
        "tax_id": "91835871954",
        "email": "bertha48@example.net",
        "created_at": "2025-07-04T12:38:40.000000Z",
        "updated_at": "2025-07-04T12:38:40.000000Z"
    },
    "month": "2025-07",
    "total_amount": 0
}
```

#### `POST /customers`

Creates a new customer.

**Payload:**
```json
{
  "name": "any name",
  "email": "any_email@mail.com",
  "tax_id": "any tax id"
}
```

---

### Charges

#### `POST /collections`

Creates a new charge associated with an existing customer.

**Payload:**
```json
{
  "customer_id": "any customer id",
  "amount": 100.00,
  "due_date": "2025-01-01",
  "description": "any description"
}
```

---

## 🧪 Tests

This project includes automated feature tests.

To run the tests:

```bash
php artisan test
```

---

## ✅ Evaluation Criteria

- Clean, organized, and maintainable code
- Proper use of Laravel best practices and PSRs
- Application of SOLID principles
- Use of Design Patterns where appropriate
- RESTful design
- Commit history and Git usage
- Test coverage and structure
- Logging and basic observability
- Optional use of Docker or OpenAPI

---

## 🚫 Out of Scope (Do not implement)

- Authentication
- Client editing/removal
- Frontend
- Asynchronous notifications
- Revenue dashboard
- Access logs beyond default Laravel logs

---

## 📝 Final Notes

Please keep your implementation as clean and expressive as possible. Use meaningful commit messages and include any extra comments or documentation that help understand your decisions.
