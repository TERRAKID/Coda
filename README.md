<br />
<p align="center">
  <a href="https://coda-app.com">
    <img src="public/img/icon.png" alt="Logo" height="80">
  </a>

  <h3 align="center">Coda</h3>

  <h4 align="center">MOVIES IN CLOSE-UP</h4>
  <p align="center">The first true social media for movie enthusiasts.</p>
</p>

## About The Project

Our idea was born out of frustration. We are very interested in film ourselves and have found that there is currently a gap in the market for proper film discussion. The film experience can be made more interesting. It is difficult to find a "sense of community" online where people can share their love for movies. It remains a challenge for people with the same film interest to find each other.

To solve these problems, we built a movie platform where you can review movies, earn badges and levels, log movies and share your experience with other users in an intimate atmosphere through the communities system. In this way everyone feels heard and there is open discussion that is constantly being stimulated. We also offer much more personalization, something that users greatly miss with existing platforms. This is how we build the new social media for film. 

### Built With

* [Laravel Jetstream](https://jetstream.laravel.com)
* [Tailwind CSS](https://tailwindcss.com)
* [Vue.js](https://vuejs.org)
* [Inertia.js](https://inertiajs.com)
* [Laravel](https://laravel.com)

### APIs

* [Pusher](https://pusher.com)
* [The Movie Database API](https://developers.themoviedb.org)

## Getting Started

### Prerequisites

* [Docker Desktop](https://www.docker.com/products/docker-desktop)
* [Windows Subsystem for Linux 2](https://docs.microsoft.com/en-us/windows/wsl/install-win10)
* [Ubuntu](https://www.microsoft.com/nl-be/p/ubuntu/9nblggh4msv6)

### Installation

1. Clone repo in Ubuntu
    ```sh
    git clone git@github.com:TERRAKID/Coda.git
    ```
2. Install Composer dependencies
    ```sh
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v $(pwd):/opt \
        -w /opt \
        laravelsail/php80-composer:latest \
        composer install --ignore-platform-reqs
    ```
3. Configure Bash alias
    ```sh
    alias sail='bash vendor/bin/sail'
    ```
4. Start Docker containers
    ```sh
    sail up
    ```
5. Install npm packages
    ```sh
    sail npm install
    ```
6. Compile assets
    ```sh
    sail npm run dev
    ```
7. Run migrations
    ```sh
    sail php artisan migrate
    ```

## Credits

* **Thibaud Streignart** - *Project manager* - [Jadabyte](https://github.com/Jadabyte)
* **Lars Ingelrelst** - *Chief designer* - [Lars-ingel](https://github.com/Lars-ingel)
* **Wannes Verboven** - *Lead developer* - [TERRAKID](https://github.com/TERRAKID)
