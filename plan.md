# plan.md — Taman Indah Website (Laravel + MySQL + Admin & Customer Login)

## 0) ROLE & RULES / CONSTRAINTS (MUST BE FOLLOWED)
You are a **Senior Laravel Engineer + Tech Lead**. Build this project **end-to-end** with output in the form of **fully runnable code**.

### Required output for each STAGE
For every stage, you must output:
1) **List of files created/modified** (full paths)
2) **Full code per file** (not small snippets)
3) **Commands to run**
4) **Manual test checklist** (click steps + input + expected result)
5) **Risk/edge-case notes** (if any)

### Mandatory constraints (Tech + Scope)
- Framework: **Laravel** (match the version with PHP in XAMPP)
- Database: **MySQL**
- View: **Blade + Bootstrap 5**
- UI styling must use Bootstrap 5 only (no Tailwind in final UI).
- The system has 2 roles: **admin** and **customer** → **both MUST login**
- Admin pages can only be accessed by users with the **admin** role (`/admin/*`)
- The application is **not only CRUD** and **not just a catalog**: it must include transactions, user–admin interaction, and reports
- Minimum DB **>= 5 related tables** (we will use more than 5)
- No payment gateway → payments via transfer + **upload transfer proof** in the website + manual admin verification
- Use **DB transactions** for multi-step DB operations that change orders + items + payments + stock + movements

### Business rules (must stay consistent everywhere)
- Stock **DOES NOT decrease at checkout**
- Stock decreases **ONLY when admin approves the payment proof**
- On approval, the system MUST re-check latest stock:
  - If stock is insufficient → approval is rejected (status/payment rejected)
- If an order that is already confirmed is later cancelled → stock is returned
- Sales report counts only orders with status **picked_up** and uses `picked_up_at`

## Security / Constraints (MUST FOLLOW)
- Prioritize performance and keep solutions simple (no over-engineering).
- Minimize cloud/API costs where possible (avoid unnecessary external network calls/tools). This refers to external services (including AI tool usage), not local DB queries within the app.
- Database operations must be secure and efficient:
  - Use validation for all user input (FormRequest).
  - Use Eloquent relationships and avoid N+1 queries (use eager loading where needed).
  - Use DB transactions for multi-step operations that modify order/payment/stock.
- Add proper logging for critical operations (server-side logs), at minimum:
  - Payment submitted (customer uploads proof)
  - Payment approved/rejected (admin review)
  - Stock committed on approve, and stock returned on cancel
  - Order status transitions (confirmed/ready/picked_up/cancelled)
- Use Laravel logging (`Log::info`, `Log::warning`) with structured context arrays (e.g., order_id, order_code, user_id, action).
- Logs must be written to the default Laravel log file: `storage/logs/laravel.log`.
- Never log sensitive data:
  - Do not log passwords, full card/account numbers, or uploaded proof image binary.
  - Logs may include order_code, order_id, user_id, action, and timestamps.

### Requested UI/UX
- Admin: consistent layout with a **left sidebar** (admin menus/functions) across all admin pages
- Customer: main page designed to **scroll down** (single-page feel) using section anchors (e.g., #catalog, #how-to-order, #my-orders, #upload-proof). Detail/checkout pages may be separate if needed.

### Execution rules (MUST FOLLOW)
- Work only on one STAGE at a time.
- Do not jump ahead.
- Before coding, restate the STAGE goal.
- After coding, output file list + full files + commands + manual tests.
- Stop after completing the current STAGE. Do not start the next STAGE unless explicitly asked.

---

## SOP FOR CURSOR (MUST FOLLOW)
When working on each STAGE:
1) First, inspect the current repository structure before writing new code:
   - routes, models, migrations, views, middleware, services
2) Do NOT create duplicate files or duplicate implementations.
   - If something already exists, MODIFY the correct file instead of creating a new one.
3) Every time you provide code, use this exact format:
   - `File: path/to/file.php`
   - (then paste the FULL file content, not snippets)
4) At the end of each STAGE, you MUST provide:
   - Commands to run (composer/npm/artisan)
   - What success looks like (expected outputs)
   - Manual test checklist (step-by-step clicks + inputs + expected results)
5) Do NOT proceed to the next stage until the current stage meets its “Definition of Done (DoD)”.
6) Keep all business rules consistent with this plan:
   - Stock decreases ONLY after Admin approves the payment proof
   - Use DB transactions for any operation that changes orders + items + payments + stock + movements

---

## DEFINITION OF DONE (DoD) PER STAGE
Stage 1 is DONE if:
- Customer can register/login; Admin can login
- `users.role` exists and works (admin/customer)
- Non-admin users cannot access `/admin/*` (403 or redirect)
- Login redirects correctly:
  - admin → `/admin/dashboard`
  - customer → `/`

Stage 2 is DONE if:
- All required tables exist and are related correctly:
  - users, categories, products, orders, order_items, payments, stock_movements
- Eloquent relationships work (no missing FK errors)
- Seeders run successfully and data is visible in MySQL

Stage 3 is DONE if:
- Admin layout has a LEFT SIDEBAR and is consistent across all admin pages
- Dashboard loads without errors and shows at least 3 summary cards

Stage 4 is DONE if:
- Category CRUD works with validation
- Deleting a category that is used by products is blocked with a clear error message

Stage 5 is DONE if:
- Product CRUD works with validation
- Image upload saves to storage and displays correctly
- `is_active` toggle works and affects customer catalog visibility

Stage 6 is DONE if:
- Admin can add/remove/adjust stock with validation (stock never negative)
- Every stock change creates a `stock_movements` record
- Stock history filtering works

Stage 7 is DONE if:
- Customer home page supports “scroll down” sections (anchors)
- Catalog section shows only active products, with search/filter/pagination
- Product detail page works

Stage 8 is DONE if:
- Cart add/update/remove works
- Quantity cannot exceed current stock
- Checkout requires login

Stage 9 is DONE if:
- Checkout creates an order with status `pending_payment`
- Order items are created with price snapshot
- Stock does NOT change on checkout
- `order_code` format is correct and unique (TI-YYYY-00001)
- Cart is cleared after successful checkout

Stage 10 is DONE if:
- Customer can view “My Orders” list and order detail
- Customer can upload payment proof for a `pending_payment` order
- Upload creates/updates `payments` (including amount + proof_image_path) and sets order status to `payment_submitted`
- Payment proof overwrite behavior is implemented (no history table)

Stage 11 is DONE if:
- Admin can review submitted payments and view the proof image
- Approve operation:
  - Uses DB transaction
  - Re-checks latest stock before committing
  - Decreases stock ONLY on approve
  - Creates `stock_movements` type `approve_commit`
  - Sets order status to `confirmed`
- Reject operation:
  - Uses DB transaction
  - Sets payment to rejected with admin note
  - Sets order status to rejected (do not revert to pending_payment)

Stage 12 is DONE if:
- Admin can move order status: `confirmed` → `ready` → `picked_up`
- Cancel rules work:
  - Cancel after confirmed/ready returns stock and creates `stock_movements` type `return`
  - Cancel before confirmed does not affect stock
- Orders with status `picked_up` are locked (cannot be modified)

Stage 13 is DONE if:
- Sales report filters by date range correctly using `picked_up_at`
- Report shows transaction count + total revenue
- Print-friendly report page renders correctly

---

## REQUIRED EDGE CASES (MUST HANDLE)
1) Admin approves payment when stock is insufficient:
   - The system MUST block approval and show a clear error message
   - No stock changes, no partial updates (transaction rollback)

2) Customer uploads payment proof multiple times:
   - MUST overwrite/replace the existing proof for the same order (no history table).
   - Update the existing payment record and replace the stored proof file.

3) Orders that are `picked_up` must be immutable:
   - No status changes, no cancel, no payment re-review

4) Cancel after stock has been committed (after approved/confirmed):
   - Must return stock accurately
   - Must create `stock_movements` type `return`
   - Must use DB transaction

5) Product deactivated (`is_active=false`):
   - Must not appear in customer catalog
   - Existing orders referencing the product must still display correctly

6) File upload validations:
   - Accept only jpg/png/webp
   - Enforce max file size
   - Store files under `storage/app/public/...` and ensure `storage:link` is documented

7) Order code uniqueness and format:
   - Must be unique
   - Must follow TI-YYYY-00001 format
   - Must not break on concurrent order creation (use DB-safe approach)

8) Double-submit prevention:
   - Prevent accidental duplicate checkout submissions creating duplicate orders
   - Prevent admin double-approve causing double stock deduction (idempotency checks)

---

## 1) PROJECT CONTENT (Brief)
Final Project title: “Design and Build a Web-Based Sales and Ordering Information System for Ornamental Plants at ‘Taman Indah’ Store, Malang City”.

Actors:
- Admin
- Customer (login)

Definitions:
- **Ordering**: an order is created by the customer
- **Sales**: orders with status **picked_up** (collected/completed) → appear in the sales report

Main transactions:
- Customer creates an order + uploads transfer proof
- Admin verifies payment + approve/reject
- Stock changes on approval
- Admin manages order status until completion
- The system generates a sales report

---

## 2) FINAL FEATURES (SCOPE)
### 2.1 Customer Features (Login)
1) Customer register & login
2) Main page (scroll):
   - Catalog section (search, category filter, pagination)
   - How to order section (flow)
   - My Orders section (user order list)
   - Track/Order Detail section (via list, not public)
3) Product detail
4) Cart (session or DB) + checkout
5) After checkout: order is created with status **pending_payment**
6) Upload transfer proof for the order → status **payment_submitted**
7) Order history + status (pending_payment, payment_submitted, confirmed, ready, picked_up, cancelled, rejected)

### 2.2 Admin Features (Login, admin role)
1) Admin login
2) Admin dashboard (summary: total products, pending payment, confirmed, picked_up)
3) Category CRUD
4) Product CRUD + photo upload + active/inactive
5) Stock management + stock history (audit)
6) Order management:
   - list + status filter + search
   - order detail + items
   - payment verification (view transfer proof)
   - approve/reject payment
   - update order status: confirmed → ready → picked_up
   - cancel order (with stock rules)
7) Sales report:
   - date filter
   - transaction recap + total revenue
   - print-friendly

---

## 3) DATABASE DESIGN (>= 5 RELATED TABLES)
We use the following tables:

### 3.1 users
- id, name, email, password, role (enum: admin/customer), timestamps

### 3.2 categories
- id, name, timestamps

### 3.3 products
- id, category_id (FK), name, price (decimal), stock (int), description (text nullable),
  image_path (nullable), is_active (bool default true), timestamps

### 3.4 orders
- id, user_id (FK), order_code (unique),
  status (string): pending_payment, payment_submitted, confirmed, ready, picked_up, cancelled, rejected
  total_amount (decimal),
  note (text nullable),
  status timestamps:
    - payment_submitted_at nullable
    - confirmed_at nullable
    - ready_at nullable
    - picked_up_at nullable
    - cancelled_at nullable
    - rejected_at nullable
  timestamps

### 3.5 order_items
- id, order_id (FK), product_id (FK), qty (int),
  price (decimal snapshot), subtotal (decimal), timestamps

### 3.6 payments (transfer proof)
- id, order_id (FK unique), payer_name (nullable),
  bank_name (nullable), account_number (nullable),
  amount (decimal), proof_image_path (string),
  status (string): submitted, approved, rejected
  admin_note (text nullable),
  submitted_at, reviewed_at (nullable),
  reviewed_by_admin_id (FK nullable),
  timestamps

### 3.7 stock_movements (stock audit)
- id, product_id (FK),
  type (string): in, out, approve_commit, return, adjust
  qty (int),
  note (text nullable),
  ref_order_id (FK nullable),
  created_by_admin_id (FK nullable),
  timestamps

Eloquent Relationships:
- User hasMany Orders
- Category hasMany Products
- Product belongsTo Category
- Order belongsTo User, hasMany OrderItems, hasOne Payment
- OrderItem belongsTo Order & Product
- Payment belongsTo Order, reviewed_by_admin_id -> User (admin)
- Product hasMany StockMovements
- Order hasMany StockMovements (via ref_order_id)

---

## 4) STATUS FLOW (VERY IMPORTANT)
### Customer
- checkout → Order status = **pending_payment**
- upload proof → Payment status = submitted, Order status = **payment_submitted**

### Admin
- review proof:
  - if valid & stock is sufficient → Payment status = approved, Order status = **confirmed**, stock decreases
  - if not valid → Payment status = rejected, Order status = rejected (do not revert to pending_payment)
- after confirmed:
  - confirmed → ready → picked_up
- cancel:
  - if cancelled after confirmed: stock is returned (return movement)
  - if cancelled before confirmed: stock does not change

---

## 5) ROUTES & MODULE STRUCTURE
### Routes files
- routes/web.php (customer + public)
- routes/admin.php (admin)

### Middleware
- auth (Laravel default)
- role:admin
- role:customer (optional, auth-only is enough for customer area)

### Controller structure
- app/Http/Controllers/Admin/*
  - DashboardController
  - CategoryController
  - ProductController
  - StockController
  - OrderController
  - PaymentReviewController
  - ReportController

- app/Http/Controllers/Customer/*
  - HomeController (single-page scroll)
  - CatalogController
  - CartController
  - CheckoutController
  - OrderController (my orders)
  - PaymentController (upload proof)

### Requests (FormRequest)
- app/Http/Requests/Admin/*
- app/Http/Requests/Customer/*

### Services
- app/Services/OrderService.php (create order & totals)
- app/Services/PaymentApprovalService.php (approve/reject + stock commit + movements) [MUST USE TRANSACTION]
- app/Services/StockService.php (apply movement rules)

---

## 6) IMPLEMENTATION PLAN (STAGE BY STAGE, END-TO-END)

# STAGE 0 — Setup Laravel version decision
Goal: match Laravel with PHP in XAMPP.
Tasks:
1) Explain how to check PHP version (`php -v`).
2) Determine Laravel version:
   - PHP >= 8.2 → Laravel 11
   - PHP 8.1 → Laravel 10
3) Create a final Decision Log.
Output: project installation steps based on the chosen version.

---

# STAGE 1 — Init Laravel + Auth (Admin & Customer)
Goal: customer register/login + admin login with role.
Tasks:
1) Create Laravel project.
2) Setup MySQL .env.
3) Install Breeze (Blade).
4) After installing Breeze (Blade), convert all Breeze auth views to Bootstrap 5 (do not use Tailwind in final UI).
5) Add `role` column in users migration or create a new migration.
6) Seed 2 accounts:
   - Admin: admin@tamanindah.test / password123 / role=admin
   - Customer: user@tamanindah.test / password123 / role=customer
7) Create `role:admin` middleware and apply to /admin/*
8) Redirect after login:
   - admin → /admin/dashboard
   - customer → / (home scroll page)
Full output: middleware files, route grouping, seeder, redirect logic.

---

# STAGE 2 — Migrations + Models + Seed Data
Goal: create all tables + relationships.
Tasks:
1) Create migrations: categories, products, orders, order_items, payments, stock_movements.
2) Create models + relationships + casts.
3) Seed:
   - at least 3 categories
   - at least 8 products (varied stock & price)
Output: all migration/model/seeder files + migrate & seed commands + check via phpMyAdmin.

---

# STAGE 3 — Admin Layout (consistent left sidebar) + Dashboard
Goal: clean & consistent admin UI.
Tasks:
1) Create admin layout: left sidebar + topbar.
2) Sidebar menu:
   - Dashboard
   - Categories
   - Products
   - Stock
   - Orders
   - Payment Review
   - Reports
3) Create dashboard with summary cards:
   - total active products
   - orders pending_payment/payment_submitted
   - orders confirmed
   - orders picked_up this month
Output: blade layout + dashboard view + controller.

---

# STAGE 4 — CRUD Categories (Admin)
Goal: categories done.
Tasks:
1) Resource routes /admin/categories.
2) FormRequest validation (name required).
3) Views: index/create/edit.
4) Delete rule: block delete if category is used by products.
Output: controller + requests + views + manual test.

---

# STAGE 5 — CRUD Products + Photo upload + Active/Inactive (Admin)
Goal: products done.
Tasks:
1) Product list: search + category filter + pagination.
2) Create/Edit:
   - name required
   - price decimal >= 0
   - stock int >= 0
   - image optional (jpg/png/webp)
3) Upload to `storage/app/public/products` + `php artisan storage:link`.
4) Toggle is_active.
Output: controller + requests + views + routes + manual test.

---

# STAGE 6 — Stock Management + Audit (Admin)
Goal: admin can manage stock & it is recorded.
Tasks:
1) Page /admin/stocks:
   - select product
   - type: in/out/adjust
   - qty
   - note
2) Rules:
   - out must not make stock negative
   - adjust: set stock to a new value (qty = new stock), record delta in note
3) Wrap stock update + stock_movements insert in a single DB transaction.
4) Stock history page:
   - filter product + date range
   - table: date, product, type, qty, note, admin, ref_order
Output: controller + requests + views + StockService.

---

# STAGE 7 — Customer Home (Single Page Scroll) + Catalog Section
Goal: customer page is scrollable with sections.
Tasks:
1) Home page `/`:
   - hero
   - section #catalog (active product list + search + category filter)
   - section #how-to-order (flow)
   - section #my-orders (requires login → show login button if guest)
2) Navbar with anchor links:
   - Catalog (#catalog)
   - How to Order (#how-to-order)
   - My Orders (#my-orders)
   - Cart (/cart)
3) Product cards link to detail page `/products/{id}` (can be separate).
Output: HomeController + views + Catalog query.

---

# STAGE 8 — Cart (Customer, login required for checkout)
Goal: cart works.
Tasks:
1) Cart uses session:
   - cart = { product_id: qty }
2) Add to cart from detail/list:
   - validate qty >=1 and <= current stock
3) Page /cart:
   - item list, update qty, remove
   - total
4) Checkout button:
   - if user not logged in → redirect to login
Output: CartController + views.

---

# STAGE 9 — Checkout -> Create Order (stock not reduced yet)
Goal: order is created with pending_payment status.
Tasks:
1) Checkout form:
   - note optional
2) Submit checkout:
   - ensure cart is not empty
   - Wrap the entire checkout DB write (create order + create order_items) in a single DB transaction.
   - create orders:
     - user_id = auth user
     - status = pending_payment
     - total_amount from calculation
     - order_code format: TI-YYYY-00001 (use id)
   - create order_items with price snapshot
   - stock does not change at this stage
   - Clear the cart session after successful checkout.
3) After success:
   - redirect to the order detail page “My Orders” with instructions to upload transfer proof
Output: OrderService + CheckoutController + views.

---

# STAGE 10 — My Orders + Upload Transfer Proof (Customer)
Goal: user can view orders & upload proof.
Tasks:
1) Page `/my-orders` (login required):
   - list user’s orders with status badges
2) Page `/my-orders/{order}`:
   - item details + total + status
   - if status is pending_payment:
     - show upload transfer proof form (amount + proof_image)
3) On upload:
   - save file to `storage/app/public/payments`
   - Use a DB transaction for DB updates (create/update payments + update order status/timestamps). (File upload is outside DB transaction; only DB writes must be atomic.)
   - If a payment record already exists for the order, overwrite/replace the existing proof file and update the same payment record (no history table).
   - create/update `payments` record:
     - amount = input amount
     - proof_image_path = stored file path
     - status=submitted
     - submitted_at = now
   - update order:
     - status = payment_submitted
     - payment_submitted_at = now
Output: Customer OrderController + PaymentController + request validation + views.

---

# STAGE 11 — Admin Review Payment (Approve/Reject) + Commit Stock on Approve (TRANSACTION)
Goal: admin verifies proof and stock decreases on approve.
Tasks:
1) Admin page `/admin/payments`:
   - list submitted payments + filters
2) Admin payment detail:
   - show proof image
   - Approve / Reject buttons
   - admin_note input (reason)

3) Approve (MUST use DB transaction):
   - Only allow approve if payment.status is still submitted (prevent double-review)
   - load order + items
   - check latest stock for each product:
     - if any item qty > stock → approval fails, show error “insufficient stock”
   - if sufficient:
     - decrease products.stock by qty
     - create stock_movements type=approve_commit qty=qty, ref_order_id, created_by_admin_id=admin
     - update payment:
       - status=approved, reviewed_at=now, reviewed_by_admin_id
     - update order:
       - status=confirmed, confirmed_at=now

4) Reject (MUST use DB transaction):
   - Only allow reject if payment.status is still submitted (prevent double-review)
   - payment status=rejected
   - set payment.admin_note = admin_note and set reviewed_at/reviewed_by_admin_id if applicable
   - set order.status = rejected (do not revert to pending_payment)

5) Ensure only admins can access (admin role).
Output: PaymentReviewController + PaymentApprovalService + views.

---

# STAGE 12 — Admin Orders Management (next statuses + cancel + return stock)
Goal: admin manages order status until completion.
Tasks:
1) `/admin/orders`:
   - search order_code / user / status
   - filter status
2) `/admin/orders/{id}` detail
3) Update statuses:
   - confirmed -> ready (ready_at)
   - ready -> picked_up (picked_up_at)
4) Cancel rule:
   - if cancelled while confirmed/ready:
     - DB transaction:
       - return stock (increase stock)
       - stock_movements type=return, ref_order_id, created_by_admin_id
       - order status=cancelled, cancelled_at
   - if cancelled while pending_payment/payment_submitted:
     - order status=cancelled (stock has not changed yet)
5) Lock rule:
   - picked_up cannot be changed again
Output: Admin OrderController + request validation + views.

---

# STAGE 13 — Sales Report + Print (Admin)
Goal: sales report meets academic requirements.
Sales definition: order status = picked_up, date uses picked_up_at.
Tasks:
1) `/admin/reports/sales`:
   - date_from/date_to filters
   - query picked_up_at in range
   - show: total transactions, total revenue
   - table of orders
2) Print-friendly view `/admin/reports/sales/print?...`
Output: ReportController + views + manual print test.

---

## 7) Acceptance Criteria (Final Checklist)
- [ ] Related tables >= 5 (users, categories, products, orders, order_items, payments, stock_movements)
- [ ] Admin & customer can register/login
- [ ] Admin area is restricted to admin role only
- [ ] Admin CRUD categories & products (photo upload) + active toggle
- [ ] Customer can checkout and create a pending_payment order
- [ ] Customer can upload transfer proof (payment_submitted)
- [ ] Admin can approve/reject payments
- [ ] Stock decreases only on approve (and recorded in stock_movements)
- [ ] Admin can process status until picked_up
- [ ] Cancel after confirmed returns stock
- [ ] Sales report date filter + print works

---

DONE. Run stages 0 to 13 in order and output all files + full code according to the rules.