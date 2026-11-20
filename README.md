# BMI Calculator

A small browser-based BMI calculator with a PHP endpoint that stores each calculation in MySQL.

## Features

- Enter height in centimetres and weight in kilograms.
- Calculate BMI immediately in the browser.
- Display a basic adult BMI category.
- Send height and weight to PHP for server-side validation and calculation.
- Store validated records in MySQL.
- Display whether the record was saved successfully.

## Technology

HTML, CSS, JavaScript, PHP 8+, MySQL, and the browser Fetch API.

## Local setup

Requirements: PHP 8+ with the MySQLi extension, MySQL 8+ or MariaDB, and a local PHP-capable web server.

1. Clone or download the repository.
2. Create the database and table by importing `schema.sql`:

   ```bash
   mysql -u root -p < schema.sql
   ```

3. Configure the database connection using environment variables:

   | Variable | Default | Purpose |
   |---|---|---|
   | `DB_HOST` | `localhost` | MySQL server |
   | `DB_NAME` | `bmi_db` | Database name |
   | `DB_USER` | `root` | Database user |
   | `DB_PASS` | empty | Database password |

   The defaults are intended only for local development. Use a dedicated database user and a strong password outside a local machine.

4. Start the PHP development server from the project folder:

   ```bash
   php -S 127.0.0.1:8000
   ```

5. Open http://127.0.0.1:8000/one.html.

## Calculation and data handling

The BMI formula is:

`BMI = weight_kg / (height_m × height_m)`

The browser displays the result for immediate feedback. The PHP endpoint independently validates height and weight, recalculates BMI, and derives the category on the server. Client-submitted BMI and category values are not trusted.

The basic adult categories shown are:

- Underweight: BMI below 18.5
- Normal range: BMI 18.5 to below 25
- Overweight: BMI 25 or higher

BMI is a general screening measure, not a medical diagnosis. Interpretation can differ for children, adolescents, pregnancy, athletes, and other individual circumstances.

## Project structure

```text
BMI-Calculator/
├── one.html
├── style.css
├── script.js
├── save_data.php
├── schema.sql
└── README.md
```

## Limitations

- No user accounts or personal health profile are implemented.
- Stored measurements are not encrypted at the application layer; do not use this demo for sensitive real-world health records.
- No authentication, consent workflow, or data deletion interface is provided.
- The app is a learning project, not a medical product.

## License

See [LICENSE.txt](LICENSE.txt).
