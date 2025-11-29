# Email Setup Guide for DentalChain

## Current Issue
Emails show as "sent" but aren't actually delivered because `MAIL_MAILER=log` in your `.env` file.

## Quick Fix Options

### Option 1: Mailtrap (Recommended for Development)

**Best for:** Testing emails without sending real emails

1. **Sign up:** Go to [mailtrap.io](https://mailtrap.io) (free account)
2. **Get credentials:** Copy SMTP settings from your inbox
3. **Update `.env` file:**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=sandbox.smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your_mailtrap_username
   MAIL_PASSWORD=your_mailtrap_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="noreply@dentalchain.com"
   MAIL_FROM_NAME="DentalChain"
   ```
4. **Clear cache:** Run `php artisan config:clear`
5. **Test:** Create a new clinic and check Mailtrap inbox

---

### Option 2: Gmail SMTP (For Real Emails)

**Best for:** Sending actual emails to clinic addresses

1. **Enable 2FA:** Go to Google Account → Security → 2-Step Verification
2. **Generate App Password:**
   - Google Account → Security → App passwords
   - Select "Mail" and "Windows Computer"
   - Copy the 16-character password
3. **Update `.env` file:**
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD=your-16-char-app-password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="your-email@gmail.com"
   MAIL_FROM_NAME="DentalChain"
   ```
4. **Clear cache:** Run `php artisan config:clear`
5. **Test:** Create a new clinic

---

### Option 3: View Logged Emails (Current Setup)

**Best for:** Quick debugging without setup

Emails are currently being logged to: `storage/logs/laravel.log`

To view them:
1. Open `storage/logs/laravel.log`
2. Search for the email content (look for "Welcome" or the clinic name)
3. You'll see the full email HTML

---

## After Configuration

1. **Clear config cache:**
   ```bash
   php artisan config:clear
   ```

2. **Test email sending:**
   - Go to Admin → Clinics → Create New Clinic
   - Fill in the form with a valid email
   - Submit
   - Check your email inbox (or Mailtrap)

3. **Troubleshooting:**
   - If emails still don't send, check `storage/logs/laravel.log` for errors
   - Verify your SMTP credentials are correct
   - Make sure your firewall isn't blocking SMTP ports

---

## Email Template Location

If you want to customize the email template:
- File: `resources/views/emails/clinic_account_created.blade.php`
- Mail class: `app/Mail/ClinicAccountCreated.php`

---

## Recommended: Use Mailtrap for Development

For local development, **Mailtrap is the best choice** because:
- ✅ Free and easy to set up
- ✅ No risk of accidentally sending emails to real users
- ✅ Beautiful interface to view all test emails
- ✅ No need for Gmail app passwords
- ✅ Works immediately after setup

Once you deploy to production, you can switch to a real email service like Gmail, SendGrid, or Amazon SES.
