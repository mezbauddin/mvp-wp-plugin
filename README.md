# Microsoft MVP WordPress Plugin

This plugin helps Microsoft MVPs automatically append their `WT.mc_id` contributor ID to Microsoft links and track clicks for renewal insights.

## ✅ Features

- Automatically append tracking ID to Microsoft-related links
- Track total link clicks (GDPR-safe, no IP/user data stored)
- Dashboard chart with Chart.js (in progress)
- Bulk scan and update old posts
- CSV export of click stats
- Consent-based operation (plugin only works after user agrees)
- Clean uninstall: deletes settings and click logs
- Export/import plugin config

## ⚙️ Requirements

- WordPress 6.5+
- PHP 7.4+

## � Installation from WordPress Plugin Directory

Once approved, you'll be able to install this plugin directly from your WordPress dashboard:

**Plugins → Add New → Search for "Microsoft MVP Link Tracker"**

Or download from: https://wordpress.org/plugins/mvp-wp-plugin

## �📦 Installation

1. Upload plugin to `/wp-content/plugins/`
2. Activate it from the Plugins screen
3. Go to `Microsoft MVP` menu to configure

## 🛡 Privacy & GDPR

- No personal data (like IP or browser) is stored
- All data remains local in your WordPress DB
- Full consent gate ensures users are aware before tracking begins

## 🧹 Uninstall

- Click “Export Settings” to back up your config
- Deleting the plugin will remove:
  - All saved options
  - Click tracking table (`wp_mvp_clicks`)

---

Built with ❤️ for the MVP community.
