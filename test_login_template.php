<?php
/**
 * Simple test to verify login template configuration
 * This file is for testing purposes only - remove after verification
 */

// Include OpenEMR configuration
require_once(dirname(__FILE__) . '/interface/globals.php');

// Test the login page layout configuration
echo "<h2>Login Template Configuration Test</h2>\n";
echo "<p><strong>Current login_page_layout setting:</strong> " . ($GLOBALS['login_page_layout'] ?? 'Not set') . "</p>\n";

// Check if our custom template exists
$templatePath = dirname(__FILE__) . '/templates/login/layouts/teletonicmd_custom.html.twig';
if (file_exists($templatePath)) {
    echo "<p><strong>✅ Custom template exists:</strong> $templatePath</p>\n";
    echo "<p><strong>Template size:</strong> " . filesize($templatePath) . " bytes</p>\n";
    echo "<p><strong>Last modified:</strong> " . date('Y-m-d H:i:s', filemtime($templatePath)) . "</p>\n";
} else {
    echo "<p><strong>❌ Custom template NOT found:</strong> $templatePath</p>\n";
}

// Check if CSS file exists
$cssPath = dirname(__FILE__) . '/interface/themes/teletonic_custom/main.css';
if (file_exists($cssPath)) {
    echo "<p><strong>✅ CSS file exists:</strong> $cssPath</p>\n";
    echo "<p><strong>CSS size:</strong> " . filesize($cssPath) . " bytes</p>\n";
    echo "<p><strong>Last modified:</strong> " . date('Y-m-d H:i:s', filemtime($cssPath)) . "</p>\n";
} else {
    echo "<p><strong>❌ CSS file NOT found:</strong> $cssPath</p>\n";
}

// Check available login layout options
echo "<h3>Available Login Layout Options:</h3>\n";
if (isset($GLOBALS['login_page_layout'])) {
    // Find the configuration in globals
    include_once(dirname(__FILE__) . '/library/globals.inc.php');
    echo "<ul>\n";
    echo "<li>Currently configured: <strong>" . $GLOBALS['login_page_layout'] . "</strong></li>\n";
    echo "</ul>\n";
} else {
    echo "<p>Login page layout configuration not found.</p>\n";
}

echo "<h3>Next Steps:</h3>\n";
echo "<ol>\n";
echo "<li>Visit the OpenEMR login page to see the new template in action</li>\n";
echo "<li>Test login functionality with valid credentials</li>\n";
echo "<li>Verify accessibility features work correctly</li>\n";
echo "<li>Remove this test file after verification</li>\n";
echo "</ol>\n";
?>