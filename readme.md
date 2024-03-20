
## Prerequisites

* [composer](https://getcomposer.org/download/) needs to be installed on your and available globally.
* Your local machine needs PHP 7.4 or later.

# Installation

1. Create a new **private** repository in your personal Github account `ttp-interview-submission`.
2. `git clone` the empty `ttp-interview-submission` project to your local machine.
3. [Download this project](https://github.com/timetopet/2021-05-Interview-Project/archive/refs/heads/master.zip) and unzip to the project directory created during the clone operation.
4. **Important** Make an initial commit with the unzipped files before making any changes.
5. From the command line run 'composer install'. This will take 5-10 minutes depending your internet connection and computer.
6. Start the local server `php artisan serve` and open http://localhost:8000/widgets in your browser.


To help we've already created a migration and setup a SQLite database in app/database/database.sqlite. You should not need to manage the databse schema or make any adjustments to it. You should be able to use Eloquent to insert, read and update.

In addition we've setup the initial `/widgets` route in `routes.php` and created a `WidgetController.php` to get you started.

# Expectations

* We expect this project to take roughly 2-3 hours. 
* This project uses [Laravel 4.2](https://laravel.com/docs/4.2) 
* There are no limits on what JS libraries and/or CSS frameworks you use. Feel free to use whatever you are comfortable and most efficient with.
* Your submission will be reviewed on usability (of HTML page) and code quality. 
 
# Project Requirements

Note: you can create additional routes + urls to support the UI if needed.

### GET:http://localhost:8000/widgets

Upon initial load, this HTML page should display a form to create a widget. A widget has 3 user set fields.

```
    name - Required. The name of the widget. Needs to be unique.
    color - Required. The color of the widget. Does not need to be unique.
    description - Optional. 
```

Form should handle input and enforce input requirements.

Once at least one widget has been created, this page should show a list of all available widgets. Clicking on a widget should allow us to edit it. We should also have the option to create additional widgets as well.

Note: This url has already been created and setup in `routes.php`. 

### GET:http://localhost:8000/api/widgets

This API endpoint should return a list of all created widgets as a JSON string.

### GET:https://localhost:8000/api/widget/delete/{id}

This API endpoint delete the Widget with the supplied id.

The response should be an empty string. If we have provided an invalid ID, any HTTP code of 500 should be returned.

# Deliverables

You have two options. 

1. You can push your changes and give us access to your repository on Github and we will review your code directly there (preferred).
2. Email us a zip of the entire project directory.

# Bonus Points

* Given more time, what improvements to the existing codebase would you make? 

