# Admin Security Implementation Guide

## Overview
The admin panel has been secured with multiple layers of protection to prevent unauthorized access and brute force attacks.

## Security Features

### 1. Strong Password Requirements
When creating new admin accounts, passwords must meet these requirements:
- **Minimum length:** 12 characters
- **Mixed case:** Both uppercase and lowercase letters
- **Numbers:** At least one digit
- **Special characters:** At least one symbol (!@#$%^&*...)
- **Not compromised:** Password checked against known data breaches

### 2. Account Lockout Protection
- **Maximum failed attempts:** 5 consecutive failed login attempts
- **Lockout duration:** 30 minutes
- **Automatic unlock:** Account automatically unlocks after the lockout period
- **Warning system:** Shows remaining attempts before lockout

### 3. Rate Limiting
- **Login attempts:** Maximum 5 attempts per minute per IP address
- **Admin creation:** Maximum 3 attempts per 10 minutes (prevents abuse)
- **Too Many Requests:** Returns 429 HTTP status when exceeded

### 4. Security Logging
All security events are logged to `storage/logs/security.log`:
- Successful logins (with IP and user agent)
- Failed login attempts (with IP and attempt count)
- Account lockouts (with timestamp and IP)
- New admin account creations (with creator info)
- Last login tracking (timestamp and IP)

### 5. Session Management
- **Remember me:** Optional persistent login
- **Secure cookies:** CSRF protection enabled
- **Separate guard:** Admin authentication isolated from user authentication

## Default Admin Credentials

**IMPORTANT:** The default admin password is randomly generated during seeding.

When you run:
```bash
php artisan db:seed --class=AdminSeeder
```

The password will be displayed in the terminal. **Save it securely!**

**Email:** admin@shoemart.com
**Password:** [Generated strong password shown during seeding]

## Password Format
Generated passwords follow this pattern:
- Prefix: `Admin@2026!Secure#`
- Suffix: 8 random alphanumeric characters
- Example: `Admin@2026!Secure#L7l4AeJ9`

## How It Works

### Login Flow
1. User submits email and password
2. System checks if account is locked
   - If locked: Shows remaining lockout time
   - If unlocked: Proceeds to authentication
3. System attempts authentication
   - **Success:** 
     - Resets failed attempts counter
     - Updates last login timestamp and IP
     - Logs successful login
     - Redirects to dashboard
   - **Failure:**
     - Increments failed attempts counter
     - Checks if lockout threshold reached
     - If threshold reached: Locks account for 30 minutes
     - If not locked: Shows remaining attempts
     - Logs failed attempt with IP

### Account Lockout
When an account is locked:
- The `locked_until` timestamp is set to current time + 30 minutes
- All login attempts are blocked until this time passes
- Warning message shows minutes remaining
- Security log records the lockout event

### Failed Attempts Reset
Failed attempts are reset to 0 when:
- User successfully logs in
- Account lockout expires (automatically reset on next successful login)

## Database Schema

New security columns added to `admins` table:
```sql
failed_attempts INT DEFAULT 0
locked_until TIMESTAMP NULL
last_login_at TIMESTAMP NULL
last_login_ip VARCHAR(255) NULL
```

## Security Best Practices

### For Administrators:
1. **Never share admin credentials**
2. **Use unique passwords** (don't reuse passwords from other sites)
3. **Change default password** after first login (future feature)
4. **Enable 2FA** when available (future enhancement)
5. **Monitor security logs** regularly for suspicious activity
6. **Use strong, random passwords** when creating new admin accounts

### For Developers:
1. **Never commit credentials** to version control
2. **Use environment variables** for sensitive configuration
3. **Keep Laravel and dependencies updated**
4. **Review security logs** in `storage/logs/security.log`
5. **Test rate limiting** before deploying
6. **Backup database regularly** including security audit trails

## Monitoring and Alerts

### Check Security Logs
```bash
# View recent security events
tail -f storage/logs/security.log

# Search for failed attempts
grep "Failed admin login attempt" storage/logs/security.log

# Find account lockouts
grep "account locked" storage/logs/security.log
```

### Check Locked Accounts
```sql
SELECT email, failed_attempts, locked_until, last_login_at 
FROM admins 
WHERE locked_until IS NOT NULL AND locked_until > NOW();
```

### Unlock Account Manually (Emergency)
```sql
UPDATE admins 
SET failed_attempts = 0, locked_until = NULL 
WHERE email = 'admin@shoemart.com';
```

## Future Enhancements

Planned security improvements:
- [ ] Two-factor authentication (2FA) with email/SMS
- [ ] Password expiration policy (change every 90 days)
- [ ] Password history (prevent reusing last 5 passwords)
- [ ] IP whitelist for admin access
- [ ] Admin activity dashboard with security metrics
- [ ] Email notifications for suspicious activity
- [ ] Automated account recovery process
- [ ] Session timeout with inactivity detection

## Troubleshooting

### "Account is locked" Error
**Cause:** Too many failed login attempts
**Solution:** Wait 30 minutes or manually unlock via database

### "Too Many Requests" (429)
**Cause:** Rate limit exceeded
**Solution:** Wait 1 minute before retrying

### Can't Login After Password Reset
**Cause:** Password doesn't meet requirements
**Solution:** Ensure password has:
- 12+ characters
- Uppercase and lowercase
- Numbers and symbols
- Not found in data breaches

### Lost Admin Password
**Solution:** Run seeder to reset:
```bash
php artisan db:seed --class=AdminSeeder
```
**Note:** This will generate a new random password shown in terminal

## Configuration

### Adjust Lockout Settings
Edit `app/Http/Controllers/Admin/AdminAuthController.php`:
```php
const MAX_LOGIN_ATTEMPTS = 5;      // Change max attempts
const LOCKOUT_DURATION = 30;       // Change lockout minutes
```

### Adjust Rate Limiting
Edit `routes/web.php`:
```php
->middleware('throttle:5,1')       // 5 attempts per 1 minute
->middleware('throttle:3,10')      // 3 attempts per 10 minutes
```

### Password Requirements
Edit `AdminAuthController.php` in `storeAdmin()` method to modify `Password::min()` and rules.

## Support

For security concerns or questions:
- Review this guide
- Check security logs
- Contact system administrator
- Review Laravel security documentation

**IMPORTANT:** Never disable security features in production!
