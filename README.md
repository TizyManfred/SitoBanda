# SitoBanda - Website for the Banda Folk di Castello Tesino

This project contains the official website for the Banda Folk di Castello Tesino. It is built with PHP and MySQL and is designed to run in a Docker environment.

## Prerequisites

- Docker
- Docker Compose

## Setup Instructions

1.  **Clone the Repository**
    ```bash
    git clone <repository-url>
    cd SitoBanda
    ```

2.  **Configure Environment**
    The main configuration is handled in `src/includes/config.php`. This file is already set up for the Docker environment, but you may need to adjust settings for production, such as the `SITE_URL`.

3.  **Build and Run with Docker**
    From the root directory of the project, run:
    ```bash
    docker-compose up -d
    ```
    This command will build the required Docker images and start the web server and database containers in the background.

## Project Structure

-   `compose.yaml`: Defines the Docker services (web server, database).
-   `src/`: Contains all the PHP source code, assets, and public-facing files.
    -   `src/public/`: The web server's document root. All accessible pages and assets (CSS, JS, images) are here.
    -   `src/includes/`: Core application files, including `config.php` and database connections.
    -   `src/admin/`: The backend administration panel.
    -   `src/templates/`: Reusable HTML components like the header and footer.

## Development

The site is built with standard PHP, HTML, CSS, and JavaScript. There are no complex frameworks, so you can edit the files directly in the `src/` directory. Changes will be reflected immediately thanks to the Docker volume mount.

