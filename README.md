## Welcome

Thank you for taking the time to review this project. Your attention is greatly appreciated. Below are some key points to consider:

- **Simplified Approach:** Following the task requirements to keep it stupid simple, I've chosen to use a very minimalistic approach.
- **Missing Mechanics:** I've intentionally left out some mechanics that would be required for a real-world application, such as multiple queue workers, Laravel Horizon, etc.
- **Arbitrary Timings:** The scheduler and caching durations have been selected without extensive real-world analysis.
- **Data Sources:** The data sources utilized include `NewsAPI`, `The Guardian`, and `The New York Times`.
- **Documentation:** The API documentation has been created using the `Swagger` methodology.
- **Testing:** The API has been rigorously tested using `PHPUnit`.
- **Code Styling:** Code styling is enforced using `Laravel Pint`, adhering to the default Laravel standards with minor personal adjustments.
- **Continuous Integration:** A basic `GitHub Actions` workflow has been implemented to execute tests and perform code linting.

## Innoscripta News Aggregator API

This API serves the Innoscripta News Aggregator and is developed using Laravel and PHP 8.3.

## Requirements

- PHP 8.3
- Composer
- Database (MySQL, PostgreSQL, SQLite, etc.)

## API Documentation

The API documentation can be accessed at the `$APP_URL/docs/api` URL.

## Installation

1. Clone the repository.
2. Install dependencies using `composer install`.
3. Migrate the database with `php artisan migrate`.
4. Initiate the scheduler using `php artisan schedule:run` and define the cron job in `crontab -e`.
5. Start the queue worker with `php artisan queue:work`.

## Code Styling

Laravel Pint is utilized to enforce code styling, following the default Laravel standards with minor personal modifications.
