# Coalition Technologies WordPress Skills Test

This project is a complete, responsive WordPress conversion of the provided PSD design for the Coalition Technologies Skills Test.

---

## Quick Access & Credentials

- **Website URL:** [http://coalitiontest.local](http://coalitiontest.local) *(or [http://localhost](http://localhost))*
- **WordPress Admin Login:** [http://coalitiontest.local/wp-admin/](http://coalitiontest.local/wp-admin/) *(or [http://localhost/wp-admin/](http://localhost/wp-admin/))*
- **Admin Username:** `coalitiontest`
- **Admin Password:** `wordpresstest`

---

## Project Structure

```text
word press/
├── site/                     # Complete WordPress installation docroot
│   ├── wp-content/
│   │   ├── themes/ct-custom/ # Converted underscores theme
│   │   │   ├── inc/theme-settings.php # Custom Theme Settings (No plugin required)
│   │   │   ├── homepage.php  # Custom Homepage Template
│   │   │   ├── header.php    # Top bar & navigation
│   │   │   ├── footer.php    # Clean responsive footer
│   │   │   ├── style.css     # Responsive styles matching PSD pixel-for-pixel
│   │   │   └── ...
│   │   └── plugins/
│   │       └── contact-form-7/ # Form integration
│   ├── wp-config.php         # WordPress configuration with dynamic host handling
│   └── router.php            # Built-in PHP server router for mod_rewrite emulation
├── skills-test-source/       # Original test files (ct-custom.zip & CT_SkillTest_v1.psd)
├── mysql-data/               # Isolated standalone MySQL 8.0 data directory
├── coalitiontest.sql         # Complete MySQL database export
├── database.sql              # Duplicate database backup
├── add-hosts-entry.bat       # 1-click script to map coalitiontest.local in hosts file
├── start-server.bat          # 1-click batch launcher for MySQL + PHP server
├── start-server.ps1          # PowerShell server runner
└── README.md                 # Project documentation
```

---

## Key Requirements Completed

1. **Virtual Host / Domain:**
   - Configured for `http://coalitiontest.local` with dynamic host fallback so `http://localhost` also works seamlessly.
   - Run `add-hosts-entry.bat` as Administrator to add `127.0.0.1 coalitiontest.local` to Windows `hosts` file.

2. **WordPress Core & Credentials:**
   - Latest WordPress core installed.
   - Administrator account: `coalitiontest` / `wordpresstest`.

3. **Theme & PSD Conversion:**
   - Base `ct-custom` theme activated and fully styled to match `CT_SkillTest_v1.psd`.
   - Typography: Ubuntu font family matching PSD specifications.
   - Color palette: Coalition orange (`#ff6200`), dark charcoal (`#313131`), divider bar (`#3d3d3d`), header background (`#ededed`), submenu background (`#dcdcdc`).

4. **Homepage Template (`homepage.php`):**
   - Created `homepage.php` template.
   - Created "Homepage" page, assigned `homepage.php`, and set as Front Page in WordPress Reading Settings.
   - Content and intro text are fully manageable via the WordPress page editor (`the_content()`).

5. **Theme Settings Page (No Plugins Used):**
   - Built natively in `inc/theme-settings.php` using WordPress Settings API and `wp.media` uploader.
   - Located at **WP Admin > Theme Settings**.
   - Fields included:
     - **Image Upload for Logo:** Full media library integration with upload/select preview and remove button (with fallback to the stylized `YOURLOGO` logo).
     - **Top Phone Number:** For the top orange bar (`385.154.11.28.35`).
     - **Phone Number:** Displayed in Reach Us box (`385.154.11.28.38`).
     - **Fax Number:** Displayed in Reach Us box (`385.154.35.66.78`).
     - **Address Information:** Multi-line textarea for company address.
     - **Social Media Links:** Fields for Facebook, Twitter/X, LinkedIn, Pinterest, and Instagram with high-resolution SVG icons.
     - **Contact Form 7 Shortcode:** Configurable form shortcode.

6. **WordPress Navigation Menu:**
   - Primary menu created within WordPress with items `title 1` through `title 7` and dropdown submenus for `title 2` and `title 3` matching the PSD.
   - Features active orange indicator bar and responsive mobile hamburger menu toggle.

7. **Contact Form 7 Integration:**
   - Contact Form 7 installed and configured.
   - Form fields match PSD: Name (full width), Phone & Email (two columns), Message (textarea), and SUBMIT button in signature orange.
   - Native HTML form fallback provided in case the plugin is inactive.

8. **Clean Workspace:**
   - Duplicate downloads and temporary files removed.
   - Clean, production-ready directory structure.

---

## How to Run Locally

Double-click `start-server.bat` (or execute `start-server.ps1`). It will:
1. Start the dedicated MySQL daemon on port 3307.
2. Start the PHP web server on port 80.
3. Automatically open your browser to the site!

