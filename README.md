# henryChallenge
Technical Test For Henry Schein

Requirements and Instructions to run the Exercises.

1. Need PHP Version >= 8.2
2. In a Terminal, install composer to install vendor framework.
3. Run in the root folder of the project the command "composer install" to get vendor framework.
3. Change the file name .env.dev to .env.
4. Make sure your are running mysql in local and configure in the .env file the DB_USERNAME and DB_PASSWORD with yours. 
5. Run the custom artisan command app:configure {databaseName} (This command create the database, run the migrations and run the seeders, recommended set the name of the database henry_challenge).
6. To run the test for the exercise number #2 run the command "php artisan test"
7. To test excercise #1 run "php artisan tinker" and run the terminal "\App\Helpers\RuleEvaluator::test()"
8. To test excercise #2 run "php artisan tinker" and run the terminal "\App\Helpers\NestedSearchFilter::execute()"
9. To test excercise #3 run "php artisan tinker" and run the terminal " $appointment = \App\Models\Appointment::create(['title' => "New Meet", 'id_patient' => 1, 'id_location' => 1, 'status' => 'draft']); $appointment->transitionTo('submitted') ? 'VALID TRANSITION' : 'NOT VALID';"
