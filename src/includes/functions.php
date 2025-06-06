<?php
/**
 * Functions File
 *
 * Common functions for SitoBanda website
 * Following PSR-12 coding standards
 *
 * @author   SitoBanda Team
 * @version  1.0.0
 */

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

/**
 * Load a template part
 *
 * @param string $template Template name without .php extension
 * @param array  $args     Variables to pass to the template
 * @return void
 */
function load_template_part(string $template, array $args = []): void
{
    // Extract variables to make them available in the template
    if (!empty($args)) {
        extract($args);
    }
    
    // Check if template exists
    $template_path = TEMPLATES_PATH . $template . '.php';
    
    if (file_exists($template_path)) {
        include $template_path;
    } else {
        // Log error if template doesn't exist
        error_log("Template not found: {$template_path}");
        if (ENVIRONMENT === 'development') {
            echo "<!-- Template not found: {$template} -->";
        }
    }
}

/**
 * Generate a sanitized URL slug from a string
 *
 * @param string $string The string to slugify
 * @return string The sanitized slug
 */
function create_slug(string $string): string
{
    // Replace non letter or digit with dash
    $string = preg_replace('/[^\p{L}\p{N}]+/u', '-', $string);
    // Trim dashes from beginning and end
    $string = trim($string, '-');
    // Transliterate special characters
    $string = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
    // Convert to lowercase
    $string = strtolower($string);
    // Remove anything that isn't a word character or dash
    $string = preg_replace('/[^a-z0-9\-]/', '', $string);
    
    return $string;
}

/**
 * Format a date in Italian format
 *
 * @param string $date   Date string in any format readable by strtotime()
 * @param string $format Output format (default: Italian format)
 * @return string Formatted date
 */
function format_date(string $date, string $format = 'd F Y'): string
{
    $timestamp = strtotime($date);
    
    if ($timestamp === false) {
        return '';
    }
    
    // Italian month names
    $months = [
        'January' => 'Gennaio',
        'February' => 'Febbraio',
        'March' => 'Marzo',
        'April' => 'Aprile',
        'May' => 'Maggio',
        'June' => 'Giugno',
        'July' => 'Luglio',
        'August' => 'Agosto',
        'September' => 'Settembre',
        'October' => 'Ottobre',
        'November' => 'Novembre',
        'December' => 'Dicembre'
    ];
    
    $formatted = date($format, $timestamp);
    
    // Replace English month names with Italian ones
    foreach ($months as $en => $it) {
        $formatted = str_replace($en, $it, $formatted);
    }
    
    return $formatted;
}

/**
 * Sanitize user input
 *
 * @param mixed $data Data to sanitize
 * @return mixed Sanitized data
 */
function sanitize_input($data)
{
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = sanitize_input($value);
        }
    } else {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
    
    return $data;
}

/**
 * Get current page URL
 *
 * @return string Current URL
 */
function get_current_url(): string
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];
    
    return "{$protocol}://{$host}{$uri}";
}

/**
 * Check if the current page matches a given URL
 * Useful for highlighting active navigation items
 *
 * @param string $url URL to check against
 * @return bool True if current page matches URL
 */
function is_current_page(string $url): bool
{
    $current_page = basename($_SERVER['PHP_SELF']);
    $url_parts = parse_url($url);
    
    if (isset($url_parts['path'])) {
        $path = $url_parts['path'];
        $page_name = basename($path);
        
        return $current_page === $page_name;
    }
    
    return false;
}

/**
 * Format a price in Euro
 *
 * @param float  $price  Price to format
 * @param int    $decimals Number of decimal places
 * @return string Formatted price
 */
function format_price(float $price, int $decimals = 2): string
{
    return number_format($price, $decimals, ',', '.') . ' €';
}

/**
 * Generate JSON-LD structured data for an event
 *
 * @param array $event Event data
 * @return string JSON-LD script tag
 */
function generate_event_schema(array $event): string
{
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Event',
        'name' => $event['title'],
        'startDate' => $event['start_date'],
        'endDate' => $event['end_date'] ?? $event['start_date'],
        'location' => [
            '@type' => 'Place',
            'name' => $event['location_name'],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $event['address'] ?? '',
                'addressLocality' => $event['city'] ?? '',
                'postalCode' => $event['postal_code'] ?? '',
                'addressRegion' => $event['region'] ?? 'Trentino',
                'addressCountry' => 'IT'
            ]
        ],
        'performer' => [
            '@type' => 'MusicGroup',
            'name' => SITE_NAME
        ],
        'description' => $event['description'] ?? '',
        'image' => isset($event['image']) ? SITE_URL . $event['image'] : '',
        'offers' => [
            '@type' => 'Offer',
            'price' => $event['price'] ?? '0',
            'priceCurrency' => 'EUR',
            'availability' => 'https://schema.org/InStock',
            'url' => get_current_url()
        ]
    ];
    
    return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
}

/**
 * Truncate text to a specific length and append ellipsis
 *
 * @param string $text   Text to truncate
 * @param int    $length Maximum length
 * @param string $append String to append if truncated
 * @return string Truncated text
 */
function truncate_text(string $text, int $length = 150, string $append = '...'): string
{
    if (strlen($text) <= $length) {
        return $text;
    }
    
    $text = substr($text, 0, $length);
    $text = substr($text, 0, strrpos($text, ' '));
    
    return $text . $append;
}

/**
 * Get upcoming events
 *
 * @param int $limit Number of events to retrieve
 * @return array List of upcoming events
 */
function get_upcoming_events(int $limit = 3): array
{
    // This is a placeholder - in a real application, you would fetch this from a database
    // For now, we'll return sample data
    return [
        [
            'id' => 1,
            'title' => 'Concerto d\'Estate',
            'start_date' => '2025-07-15T20:00:00',
            'location_name' => 'Piazza Maggiore',
            'city' => 'Castello Tesino',
            'description' => 'Concerto estivo della Banda Folk con musiche tradizionali trentine.',
            'image' => '/assets/images/events/concert-summer.jpg'
        ],
        [
            'id' => 2,
            'title' => 'Festival del Folklore',
            'start_date' => '2025-08-10T18:30:00',
            'location_name' => 'Centro Storico',
            'city' => 'Trento',
            'description' => 'Partecipazione al Festival del Folklore di Trento con esibizione di danze e musiche tradizionali.',
            'image' => '/assets/images/events/festival-folklore.jpg'
        ],
        [
            'id' => 3,
            'title' => 'Sagra di San Martino',
            'start_date' => '2025-11-11T15:00:00',
            'location_name' => 'Chiesa di San Martino',
            'city' => 'Castello Tesino',
            'description' => 'Tradizionale esibizione in occasione della Sagra di San Martino.',
            'image' => '/assets/images/events/sagra-san-martino.jpg'
        ]
    ];
}

/**
 * Get band members
 *
 * @return array List of band members
 */
function get_band_members(): array
{
    // This is a placeholder - in a real application, you would fetch this from a database
    return [
        [
            'name' => 'Mario Rossi',
            'role' => 'Direttore',
            'image' => '/assets/images/team/director.jpg',
            'bio' => 'Direttore della banda dal 2010.'
        ],
        [
            'name' => 'Giuseppe Bianchi',
            'role' => 'Flauto',
            'image' => '/assets/images/team/flute.jpg',
            'bio' => 'Membro della banda dal 2005.'
        ],
        [
            'name' => 'Anna Verdi',
            'role' => 'Clarinetto',
            'image' => '/assets/images/team/clarinet.jpg',
            'bio' => 'Membro della banda dal 2012.'
        ]
    ];
}

/**
 * Generate pagination HTML
 *
 * @param int $current_page Current page number
 * @param int $total_pages  Total number of pages
 * @param string $base_url  Base URL for pagination links
 * @return string HTML for pagination
 */
function generate_pagination(int $current_page, int $total_pages, string $base_url): string
{
    if ($total_pages <= 1) {
        return '';
    }
    
    $html = '<nav aria-label="Paginazione"><ul class="pagination">';
    
    // Previous button
    if ($current_page > 1) {
        $html .= '<li class="page-item"><a class="page-link" href="' . $base_url . '?page=' . ($current_page - 1) . '" aria-label="Precedente"><span aria-hidden="true">&laquo;</span></a></li>';
    } else {
        $html .= '<li class="page-item disabled"><span class="page-link" aria-hidden="true">&laquo;</span></li>';
    }
    
    // Page numbers
    $start = max(1, $current_page - 2);
    $end = min($total_pages, $current_page + 2);
    
    if ($start > 1) {
        $html .= '<li class="page-item"><a class="page-link" href="' . $base_url . '?page=1">1</a></li>';
        if ($start > 2) {
            $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }
    
    for ($i = $start; $i <= $end; $i++) {
        if ($i == $current_page) {
            $html .= '<li class="page-item active" aria-current="page"><span class="page-link">' . $i . '</span></li>';
        } else {
            $html .= '<li class="page-item"><a class="page-link" href="' . $base_url . '?page=' . $i . '">' . $i . '</a></li>';
        }
    }
    
    if ($end < $total_pages) {
        if ($end < $total_pages - 1) {
            $html .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
        $html .= '<li class="page-item"><a class="page-link" href="' . $base_url . '?page=' . $total_pages . '">' . $total_pages . '</a></li>';
    }
    
    // Next button
    if ($current_page < $total_pages) {
        $html .= '<li class="page-item"><a class="page-link" href="' . $base_url . '?page=' . ($current_page + 1) . '" aria-label="Successivo"><span aria-hidden="true">&raquo;</span></a></li>';
    } else {
        $html .= '<li class="page-item disabled"><span class="page-link" aria-hidden="true">&raquo;</span></li>';
    }
    
    $html .= '</ul></nav>';
    
    return $html;
}

/**
 * Format timestamp to a human-readable time ago string in Italian
 *
 * @param string $datetime Timestamp in database format
 * @return string Formatted time ago string in Italian
 */
function timeAgo(string $datetime): string
{
    $time = strtotime($datetime);
    $now = time();
    $diff = $now - $time;

    if ($diff < 60) {
        return 'poco fa';
    } elseif ($diff < 3600) {
        $mins = floor($diff / 60);
        return $mins . ' min' . ($mins > 1 ? ' fa' : ' fa');
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ' ora' . ($hours > 1 ? 'e fa' : ' fa');
    } elseif ($diff < 604800) {
        $days = floor($diff / 86400);
        return $days . ' giorno' . ($days > 1 ? ' fa' : ' fa');
    } elseif ($diff < 2592000) {
        $weeks = floor($diff / 604800);
        return $weeks . ' settimana' . ($weeks > 1 ? 'e fa' : ' fa');
    } elseif ($diff < 31536000) {
        $months = floor($diff / 2592000);
        return $months . ' mese' . ($months > 1 ? ' fa' : ' fa');
    } else {
        $years = floor($diff / 31536000);
        return $years . ' anno' . ($years > 1 ? ' fa' : ' fa');
    }
}
