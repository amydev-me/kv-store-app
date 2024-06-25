## Code Coverage

[![codecov](https://codecov.io/github/amydev-me/kv-store-app/graph/badge.svg?token=KLRC73TSGS)](https://codecov.io/github/amydev-me/kv-store-app)


# Laravel KeyValue API

This repository contains a Laravel-based API that provides key-value storage functionality. The API supports storing key-value pairs, retrieving the latest value by key, retrieving values at specific timestamps, and fetching all stored records with pagination. 

## Technologies Used

- **PHP:** 8.2
- **Laravel:** 11
- **Database:** MySQL (RDS for production and testing)
- **CI/CD:** GitHub Actions
- **Deployment:** AWS Elastic Beanstalk
- **Testing:** PHPUnit
- **API Documentation and Testing:** Postman

## Prerequisites

- **PHP:** >= 8.2
- **Composer**
- **MySQL or any other supported database**
- **Node.js and npm (for frontend and other dependencies)**

## Installation

1. **Clone the repository:**

    ```sh
    git clone <repository_url>
    cd <repository_name>
    ```

2. **Install dependencies:**

    ```sh
    composer install
    npm install
    ```

3. **Copy the `.env` file and set up the environment variables:**

    ```sh
    cp .env.example .env
    ```

    Update the `.env` file with your database credentials and other configuration settings.

4. **Generate an application key:**

    ```sh
    php artisan key:generate
    ```

5. **Run the database migrations:**

    ```sh
    php artisan migrate
    ```

## Running the Application

1. **Start the local development server:**

    ```sh
    php artisan serve
    ```

## API Endpoints

- **Store a Key-Value Pair:**

    ```
    POST /api/object
    ```

    **Request Body:**

    ```json
    {
        "key": "your_key",
        "value": "your_value"
    }
    ```

- **Retrieve Latest Value by Key:**

    ```
    GET /api/object/{key}
    ```

- **Retrieve Value at Specific Timestamp:**

    ```
    GET /api/object/{key}?timestamp={timestamp}
    ```

- **Get All Records with Pagination:**

    ```
    GET /api/object/get_all_records
    ```

## Testing

1. **Run the tests:**

    ```sh
    php artisan test
    ```

    Ensure that all tests pass. The tests include feature tests for the API endpoints and unit tests for internal methods.

2. **Test Coverage Report:**

    You can generate a test coverage report to ensure comprehensive coverage of your application logic.

## CI/CD with GitHub Actions

The project is set up with GitHub Actions for continuous integration and deployment. The workflow file is located in the `.github/workflows` directory and includes steps to:

- Run tests on each push and pull request.
- Deploy the application to AWS Elastic Beanstalk on successful builds.

## Deployment

The application is deployed to AWS Elastic Beanstalk. Ensure that your Elastic Beanstalk environment is set up with the necessary configuration, including the RDS database for production.

## Postman Collection

A Postman collection for testing the API endpoints is included in the repository. You can import this collection into Postman to quickly test and explore the API.

### Importing the Collection

1. Open Postman.
2. Click on the "Import" button.
3. Select the `KV-Store.postman_collection.json` file from the `postman` directory in this repository.
4. Click "Open" to import the collection.
