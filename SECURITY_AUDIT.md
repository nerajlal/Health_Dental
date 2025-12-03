# Security Audit Report

## A. Executive Summary

**Assessment:** Critical Risk
**Overall Security Health:** Poor

The application contains **critical security vulnerabilities** that require immediate attention before any production deployment. The most severe issue is the use of hardcoded default passwords (`password123`) for new administrative and clinic accounts, which constitutes a backdoor. Additionally, there are significant gaps in password complexity enforcement, potential mass assignment vulnerabilities, and sensitive data exposure risks.

While the application leverages Laravel's built-in security features (CSRF protection, Eloquent ORM for SQL injection prevention) in many areas, the custom implementation of authentication and user management bypasses several standard security practices.

## B. Detailed Findings

### 1. Hardcoded Default Credentials (Critical)
**Description:** The application assigns the hardcoded password `password123` to all new Clinic and Distributor accounts created by administrators.
**Location:**
- `app/Http/Controllers/Admin/ClinicController.php` (Line 42)
- `app/Http/Controllers/Admin/DistributorController.php` (Line 42)
**Risk:** An attacker who knows this default password can compromise any newly created account before the user logs in.
**OWASP Category:** A07:2021-Identification and Authentication Failures.
**Recommended Fix:** Generate a strong random password or, preferably, use a password reset token flow (send an invitation link via email) so the user sets their own password initially.
**Example:**
```php
// Bad
'password' => \Hash::make('password123'),

// Better
$tempPassword = \Illuminate\Support\Str::random(12);
'password' => \Hash::make($tempPassword),
// Send $tempPassword via secure email...

// Best
// Create user without password or inactive, send Pulse/PasswordReset link
```

### 2. Weak Password Policies (High)
**Description:** Password validation only checks for a minimum of 8 characters. There are no requirements for complexity (uppercase, numbers, symbols) or compromised password checking.
**Location:**
- `app/Http/Controllers/AuthController.php`
- `app/Http/Controllers/Admin/ClinicController.php`
**Risk:** Users may set weak passwords (e.g., "password123") that are easily guessable or crackable.
**Recommended Fix:** Use Laravel's `Password::defaults()` with `mixedCase()`, `numbers()`, `symbols()`, and `uncompromised()`.

### 3. Mass Assignment Risk (Medium)
**Description:** The `User` model includes `role` in the `$fillable` array. While current controllers seem to validate input, any future code using `$request->all()` with `User::create()` could allow a user to register as an 'admin'.
**Location:** `app/Models/User.php`
**Risk:** Privilege Escalation.
**Recommended Fix:** Remove `role` from `$fillable` and assign it manually in the controller using `forceFill()` or a separate internal array, or use `Guarded` attributes for sensitive fields.

### 4. Dead/Unsafe Registration Code (Medium)
**Description:** `LandingController::partnerRegister` contains logic to create a user with a user-supplied role. While this method does not appear to be routed in `web.php` currently, its existence is a risk if exposed later.
**Location:** `app/Http/Controllers/LandingController.php`
**Risk:** Unintended public registration of privileged roles if routed.
**Recommended Fix:** Remove the method if unused, or ensure strict validation and that `is_active` remains false (as it currently is).

### 5. Sensitive Data Exposure in API/JSON (Low)
**Description:** The `checkCompetitorPrice` method allows a distributor to query competitor prices and names. While a business feature, it allows scraping of "lowest_price_distributor" names.
**Location:** `app/Http/Controllers/Distributor/ProductController.php`
**Risk:** Business intelligence leakage.
**Recommended Fix:** Limit the rate of requests or return aggregated data instead of specific competitor names if not strictly necessary.

### 6. Potential XSS in Admin Notes (Low)
**Description:** `PartnerRequest` allows a 1000-character description. If this is displayed using `{!! !!}` in any admin view (not verified, but possible), it could lead to Stored XSS.
**Location:** `app/Http/Controllers/PartnerRequestController.php`
**Risk:** Admin session hijacking.
**Recommended Fix:** Ensure all user input is displayed using `{{ }}` (Blade's default escaping).

### 7. File Upload Security (Medium)
**Description:** Product image uploads validate `image` but do not explicitly restrict SVG files (which can contain XSS) or enforce strict dimension/size limits beyond `max:2048`.
**Location:** `app/Http/Controllers/Distributor/ProductController.php`
**Risk:** Stored XSS via malicious SVG upload.
**Recommended Fix:** Explicitly allow only safe extensions: `mimes:jpeg,png,jpg,webp`.

## C. Code Quality & Architecture Notes

1.  **Manual Auth Implementation:** The application implements its own `AuthController` instead of using battle-tested starter kits like Breeze or Jetstream. This increases the surface area for bugs (e.g., proper session invalidation, rate limiting implementation).
2.  **Hardcoded Emails:** Sending passwords in emails (implied by `ClinicAccountCreated` usage) is bad practice. Emails are often sent in plain text and stored in logs.
3.  **Controller Logic:** Business logic (price calculation) is mixed into controllers (`Clinic\ProductController`). It should be moved to Services or Model Accessors to ensure consistency.

## D. Hardening Recommendations

1.  **Environment:** Ensure `APP_DEBUG` is set to `false` in production. The `.env.example` shows `false`, which is good, but verify the actual server config.
2.  **Session Security:** Set `SESSION_SECURE_COOKIE=true` and `SESSION_HTTP_ONLY=true` in `.env` for production to prevent cookie theft.
3.  **Rate Limiting:** The `PartnerRequest` endpoint (`/partner-request`) lacks explicit rate limiting in the route definition or controller. Add `throttle:6,1` middleware to prevent spam.
4.  **CSP Headers:** Implement Content Security Policy (CSP) headers to mitigate XSS risks.
5.  **Audit Logs:** Implement logging for sensitive actions (user creation, password changes, role updates) to track potential abuse.

## E. Checklist Summary

- [ ] **IMMEDIATE:** Remove `password123` hardcoding in Admin controllers.
- [ ] **IMMEDIATE:** Change password reset flow to use tokens, not email-sent passwords.
- [ ] **HIGH:** Update `User` model to guard the `role` attribute.
- [ ] **HIGH:** Enforce strong password complexity rules.
- [ ] **MEDIUM:** Add rate limiting to `partner-request` route.
- [ ] **MEDIUM:** Restrict file uploads to safe image formats (no SVGs).
- [ ] **LOW:** Clean up unused code in `LandingController`.
- [ ] **LOW:** Review `checkCompetitorPrice` for potential abuse.
