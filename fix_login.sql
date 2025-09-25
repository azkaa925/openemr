-- TeletonicMD Login Configuration SQL Fix
-- Run this if the PHP script doesn't work
--
-- Usage:
-- mysql -u root -p openemr < fix_login.sql

-- Update login page layout to use custom TeletonicMD template
UPDATE globals
SET gl_value = 'login/layouts/teletonicmd_custom.html.twig'
WHERE gl_name = 'login_page_layout';

-- Update login tagline
UPDATE globals
SET gl_value = 'Welcome to TeleTonicMD Secure Telemedicine Portal'
WHERE gl_name = 'login_tagline_text';

-- Ensure tagline is shown
UPDATE globals
SET gl_value = '1'
WHERE gl_name = 'show_tagline_on_login';

-- Show what was updated
SELECT 'Configuration Updated:' as Status;
SELECT gl_name as Setting, gl_value as Value
FROM globals
WHERE gl_name IN ('login_page_layout', 'login_tagline_text', 'show_tagline_on_login');