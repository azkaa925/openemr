# OpenEMR CSS/SCSS Files - Comprehensive List

## Overview
Total CSS/SCSS files found: 77 files in the themes directory

## Core Theme Architecture Files

### Main Theme Files
- `interface/themes/theme-defaults.scss` - Main theme configuration and defaults
- `interface/themes/style.scss` - Primary stylesheet
- `interface/themes/core.scss` - Core styling definitions
- `interface/themes/color_base.scss` - Base color system
- `interface/themes/compact-theme-defaults.scss` - Compact theme variant

### Bootstrap Integration
- `interface/themes/oe-bootstrap.scss` - OpenEMR Bootstrap integration
- `interface/themes/colors/utilities/bootstrap.scss` - Bootstrap utilities
- `interface/themes/colors/utilities/bootstrap-nav-menu.scss` - Bootstrap navigation

### RTL (Right-to-Left) Support
- `interface/themes/oemr-rtl.scss` - RTL main stylesheet
- `interface/themes/rtl.scss` - RTL styling
- `interface/themes/oemr_rtl_compact_imports.scss` - RTL compact imports
- `interface/themes/rtl_style_pdf.css` - RTL PDF styling

### Import Files
- `interface/themes/oemr_compact_imports.scss` - Compact theme imports
- `interface/themes/directional.scss` - Directional styling imports

## Color Schemes and Theming

### Main Color Themes
- `interface/themes/colors/style_cobalt_blue.scss` - Cobalt blue theme
- `interface/themes/colors/style_forest_green.scss` - Forest green theme

### Advanced Color Schemes (oe-styles)
- `interface/themes/oe-styles/style_dark.scss` - Dark theme
- `interface/themes/oe-styles/style_light.scss` - Light theme
- `interface/themes/oe-styles/style_manila.scss` - Manila theme
- `interface/themes/oe-styles/style_solar.scss` - Solar theme

### Color Utilities
- `interface/themes/colors/utilities/default_variables.scss` - Default color variables
- `interface/themes/colors/utilities/edit_globals_colors.scss` - Global color editing

## Component-Specific Styling

### Core UI Components
- `interface/themes/core/navmenu.scss` - Navigation menu styling
- `interface/themes/core/forms.scss` - Form styling
- `interface/themes/core/links.scss` - Link styling
- `interface/themes/core/cursor.scss` - Cursor definitions
- `interface/themes/core/FontAwesome.scss` - FontAwesome integration
- `interface/themes/core/list-table.scss` - List and table styling
- `interface/themes/core/addressbook.scss` - Address book styling
- `interface/themes/core/documents.scss` - Document styling
- `interface/themes/core/edit_globals.scss` - Global editing interface
- `interface/themes/core/closeDlgIframe.scss` - Dialog iframe styling

### Tab System
- `interface/themes/tabs_style_compact.scss` - Compact tab styling
- `interface/themes/tabs_style_full.scss` - Full tab styling
- `interface/themes/colors/utilities/tabs-full.scss` - Tab utilities

### Miscellaneous Components
- `interface/themes/misc/codes.scss` - Medical codes styling
- `interface/themes/misc/insurance.scss` - Insurance forms
- `interface/themes/misc/messages.scss` - Messages interface
- `interface/themes/misc/prior-authorizations.scss` - Prior authorizations
- `interface/themes/misc/procedures.scss` - Procedures interface
- `interface/themes/misc/reports.scss` - Reports styling
- `interface/themes/misc/ros.scss` - Review of Systems

## Feature-Specific Styling

### Authentication & Login
- `interface/themes/login_page.scss` - Main login page styling
- `interface/themes/colors/utilities/login.scss` - Login utilities

### Financial & Billing
- `interface/themes/colors/utilities/batch-payments.scss` - Batch payments
- `interface/themes/colors/utilities/fee-sheet.scss` - Fee sheet styling

### Clinical Features
- `interface/themes/colors/utilities/recall-flow-board.scss` - Recall flow board
- `interface/themes/colors/utilities/ros.scss` - Review of Systems utilities
- `interface/themes/colors/utilities/codes.scss` - Medical codes utilities

### External Integrations
- `interface/themes/colors/utilities/external-data.scss` - External data styling

### Help & Documentation
- `interface/themes/colors/utilities/help-files.scss` - Help files styling
- `interface/themes/oe-common/help-files-common.scss` - Common help styling

## Common/Shared Styles (oe-common)

### Shared Components
- `interface/themes/oe-common/main-common.scss` - Main common styles
- `interface/themes/oe-common/acl-common.scss` - ACL (Access Control) common
- `interface/themes/oe-common/messages-common.scss` - Messages common
- `interface/themes/oe-common/procedures-common.scss` - Procedures common
- `interface/themes/oe-common/oe-sidebar.scss` - Sidebar styling

## Calendar Integration
- `interface/themes/ajax_calendar_ie.css` - Internet Explorer calendar fixes
- `interface/themes/ajax_calendar_sass.scss` - AJAX calendar SCSS

## PDF Generation
- `interface/themes/style_pdf.scss` - PDF styling
- `interface/themes/rtl_style_pdf.css` - RTL PDF styling

## Customization Strategy for TeletonicMD

### High Priority Files for Customization
1. **Theme Core**
   - `theme-defaults.scss` - Main configuration
   - `color_base.scss` - Color system
   - `style.scss` - Primary styles

2. **Login Experience**
   - `login_page.scss` - Login page styling
   - `colors/utilities/login.scss` - Login utilities

3. **Navigation & Layout**
   - `core/navmenu.scss` - Navigation styling
   - `core/forms.scss` - Form styling

### Custom Theme Development Plan
1. Create `interface/themes/teletonicmd/` directory
2. Copy and modify core theme files
3. Implement TeletonicMD color scheme
4. Customize login templates and styling
5. Update navigation and branding elements

### TeletonicMD Color Integration
Based on the website color scheme:
- Primary Teal: #4a9b9e
- Secondary Teal: #6bb3b6
- Accent Teal: #2c7a7b
- Light Teal: #e6f3f3

These should be integrated into a custom variables file following OpenEMR's color system architecture.