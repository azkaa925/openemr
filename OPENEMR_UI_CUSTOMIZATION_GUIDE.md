# OpenEMR UI Customization Guide for TeletonicMD

## Branch: custom-ui-hipaa-compliant

This document provides a comprehensive guide for customizing the OpenEMR UI while maintaining HIPAA compliance and security standards.

## 1. Authentication Flow Analysis

### Primary Authentication Components

**Main Entry Points:**
- `index.php` - Main entry point, redirects to login
- `interface/login/login.php` - Primary login controller
- `interface/login_screen.php` - Login screen handler
- `interface/logout.php` - Logout functionality

**Authentication Process Flow:**
1. **Initial Access**: User accesses OpenEMR → `index.php` → redirects to login
2. **Login Page Rendering**: `interface/login/login.php` → Uses Twig templates → Renders login form
3. **Authentication Verification**:
   - POST to `library/auth.inc.php` with credentials
   - `AuthUtils::confirmPassword()` validates credentials
   - Session management via `SessionUtil` and `SessionTracker`
4. **Multi-Factor Authentication**: Optional MFA via `interface/usergroup/mfa_*.php`
5. **Session Management**:
   - Session validation via `AuthUtils::authCheckSession()`
   - Timeout handling via `SessionTracker::isSessionExpired()`
6. **Main Interface**: Successful login → `interface/main/main_screen.php`

### Key Integration Points for Custom Authentication

**Safe Integration Points:**
- `templates/login/` - Custom login templates (HIPAA compliant)
- `interface/themes/` - Custom styling without affecting security
- `interface/modules/custom_modules/` - Custom authentication modules

**Security-Critical Files (DO NOT MODIFY):**
- `library/auth.inc.php` - Core authentication logic
- `src/Common/Auth/AuthUtils.php` - Authentication utilities
- `src/Common/Session/SessionUtil.php` - Session management
- Database authentication tables

## 2. UI Theme Architecture

### Core Theme Structure
```
interface/themes/
├── theme-defaults.scss          # Main theme configuration
├── color_base.scss             # Color system base
├── default-variables.scss      # SCSS variables
├── core.scss                   # Core styling
├── style.scss                  # Main stylesheet
├── oe-bootstrap.scss           # Bootstrap integration
├── login_page.scss            # Login page styling
├── directional.scss           # RTL/LTR support
└── colors/                    # Color theme variants
    ├── style_cobalt_blue.scss
    └── style_forest_green.scss
```

### Template System (Twig)
```
templates/
├── login/
│   ├── base.html.twig         # Base login template
│   ├── layouts/               # Login layout variants
│   └── partials/              # Login partials
├── core/                      # Core UI templates
├── patient/                   # Patient interface templates
└── interface/                 # General interface templates
```

## 3. Customization Strategy for TeletonicMD Integration

### Phase 1: Theme Customization (Current Phase)
1. **Create Custom Theme Files**
   - Copy existing theme to `interface/themes/teletonicmd/`
   - Modify colors to match TeletonicMD branding
   - Update typography and spacing

2. **Custom Login Templates**
   - Create `templates/login/teletonicmd/` templates
   - Match TeletonicMD.com design language
   - Maintain HIPAA compliance messaging

3. **Logo Integration**
   - Update logo service configuration
   - Add TeletonicMD logos to `public/images/`

### Phase 2: Advanced UI Integration
1. **Custom Module Development**
   - Create `interface/modules/custom_modules/oe-module-teletonicmd/`
   - Integrate with existing TeletonicMD portal
   - Add custom dashboard components

2. **Portal Integration**
   - Modify patient portal templates
   - Add TeletonicMD-specific features
   - Ensure consistent branding

## 4. HIPAA Compliance Considerations

### Security Requirements Maintained
- ✅ X-Frame-Options: DENY (prevents UI redressing)
- ✅ Content-Security-Policy: frame-ancestors 'none'
- ✅ Session timeout and management
- ✅ Audit logging for all authentication events
- ✅ Multi-factor authentication support
- ✅ Password security requirements

### Safe Customization Areas
- CSS/SCSS styling files
- Twig templates (login layouts)
- Logo and branding assets
- Custom modules with proper security
- Color schemes and typography

### Areas Requiring Extreme Caution
- Authentication logic
- Session management
- Database access patterns
- Access control mechanisms
- Audit logging systems

## 5. File Structure Map for UI Customization

### Recommended Custom Directory Structure
```
interface/
├── themes/teletonicmd/          # Custom TeletonicMD theme
│   ├── variables.scss           # TeletonicMD color variables
│   ├── components.scss          # Custom components
│   ├── login.scss              # Custom login styling
│   └── main.scss               # Main theme file
├── modules/custom_modules/
│   └── oe-module-teletonicmd/   # Custom TeletonicMD module
│       ├── public/assets/       # CSS, JS, images
│       ├── templates/           # Custom Twig templates
│       └── src/                 # PHP logic
└── templates/teletonicmd/       # Custom templates
    ├── login/                   # Custom login templates
    └── components/              # Custom UI components

public/
├── images/teletonicmd/          # TeletonicMD assets
│   ├── logos/
│   ├── backgrounds/
│   └── icons/
└── assets/teletonicmd/          # Compiled assets
    ├── css/
    └── js/
```

## 6. Development Workflow

### Current Branch Strategy
- **Branch**: `custom-ui-hipaa-compliant`
- **Purpose**: Safe UI customization without affecting core security
- **Approach**: Non-invasive modifications using OpenEMR's customization frameworks

### Next Steps
1. Create theme backup (automated)
2. List all CSS/SCSS files for modification
3. Generate custom TeletonicMD theme
4. Test authentication flow integrity
5. Validate HIPAA compliance requirements

## 7. Integration Points with TeletonicMD.com

### Shared Branding Elements
- Color scheme: Primary teal (#4a9b9e), Secondary teal (#6bb3b6)
- Typography: Varela Round, Didact Gothic
- Logo and iconography
- Button and form styling

### Authentication Integration Possibilities
- Single Sign-On (SSO) considerations
- Shared session management
- Unified user experience
- Consistent branding across platforms

---

**Important**: This customization maintains full HIPAA compliance and security standards. All modifications are made through OpenEMR's official customization frameworks without touching core security functionality.