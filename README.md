# Tracking Blocker for WooCommerce®
Blocks all outbound HTTP requests to `tracking.woocommerce.com/v1/` and logs the original data sent to the endpoint for debugging and analysis.

## Description

Tracking Blocker for WooCommerce® is a lightweight WordPress plugin designed to enhance your site's privacy by preventing WooCommerce from sending data to its tracking endpoint. 

The plugin intercepts outbound HTTP requests to `tracking.woocommerce.com/v1/`, logs the original request details (URL and payload), and blocks the request entirely. This ensures that no sensitive information is sent to WooCommerce's tracking service.

## Features

- **Block Tracking Requests**: Prevents WooCommerce from sending data to its tracking endpoint.
- **Log Request Details**: Logs the blocked URL and the payload for transparency and debugging.
- **Automatic Updates**: Integrates with the GitHub repository to provide automatic plugin updates.
- **WooCommerce Compatibility**: Works seamlessly with WooCommerce without breaking core functionality.

## Installation

1. **Download the Plugin**: Clone or download the repository from GitHub.
2. **Upload the Plugin**:
    - Navigate to the WordPress admin dashboard.
    - Go to `Plugins > Add New > Upload Plugin`.
    - Upload the `tracking-blocker-for-woocommerce.zip` file.
3. **Activate the Plugin**: Activate the plugin from the `Plugins` menu in WordPress.

## Usage

The plugin works automatically upon activation. 

It intercepts HTTP requests to the WooCommerce tracking endpoint (`tracking.woocommerce.com/v1/`) and blocks them. All blocked requests and their payloads are logged to the WordPress debug log for review.

### Logs Example

Blocked request log entry:
    ```log
    Blocked outbound request to: https://tracking.woocommerce.com/v1/
    Original data sent: {
        "event": "installed",
        "site": "https://example.com",
        "timestamp": "1672455600",
        "data": {
            "woocommerce_version": "6.0",
            "php_version": "8.1.2"
        }
    }
    ```

## Development

### Requirements

- PHP 7.4 or higher
- WordPress 5.0 or higher
- WooCommerce 5.0 or higher

### Local Development

1. Clone the repository:
    ```bash
    git clone https://github.com/robertdevore/tracking-blocker-for-woocommerce.git
    ```

2. Install dependencies:
    ```bash
    composer install
    ```

3. Activate the plugin in your local WordPress environment.

### Updating the Plugin

The plugin uses the [plugin-update-checker](https://github.com/YahnisElsts/plugin-update-checker) library to fetch updates from the GitHub repository. Ensure the `main` branch is used for stable releases.

## Frequently Asked Questions (FAQ)

### Does this plugin block all WooCommerce tracking?

Yes, the plugin blocks all outbound HTTP requests to `tracking.woocommerce.com/v1/`.

### Where can I find the logs?

The plugin logs all blocked requests to the WordPress debug log. Ensure `WP_DEBUG` and `WP_DEBUG_LOG` are enabled in your `wp-config.php` file.

### Can this plugin break WooCommerce functionality?

No, the plugin only blocks tracking requests. All other WooCommerce features remain unaffected.

## Contributing

Contributions, issues, and feature requests are welcome! Feel free to check the [issues page](https://github.com/robertdevore/tracking-blocker-for-woocommerce/issues) and submit a pull request 🤘

## License

This plugin is licensed under the [GPL-2.0+](http://www.gnu.org/licenses/gpl-2.0.txt) license.