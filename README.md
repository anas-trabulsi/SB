SeedBox Test Number 4, by Anas Trabulsi
=======================================
### Application
This is test#4 (the dogs test). For this application, I used the framework `Silex`, which is a micro framework based on `Symfony`


### Usage
* Type `php -S localhost:4581 -t web/ web/index.php` in a terminal, open a browser, and go to `http://localhost:4581/`
* Click on the "Dogs List" link at the top navigation bar
* This application does not use any databases. All the data is loaded statically. The data is located in file `data/data.php`. The class there returns a JSON representation of what might be in a database

### Testing
* To execute the unit tests, you must download `sudo apt-get install phpunit` on an Ubuntu Linux box, or its equivalent in your operating system
* Then, go to the `test` folder from the terminal and type `phpunit TestDog` for example to test the `TestDog` test unit

### Design Changes
The implemented solution didn't follow the class diagram 100%. There are two changes:
* The public attributes (Dog::hairColor AND Chihuahua::hasStraightEars) were changed to private attributes with public getters and setters.
* In the class diagram, the relationship between the classes `Dog` and `ToBeWalked` is a dependency relationship, where class `Dog` depends on class `ToBeWalked`. However, in the implemented solution, it was first changed to the opposite (class `ToBeWalked` depends on class `Dog`). The reason is that class `ToBeWalked` needs to know which particular dog to walk, which implies that it depends on class `Dog`.
* Furthermore, a dependency in the opposite direction was also added later (class `Dog` depends on class `ToBeWalked`). The reason behind that is to make the system simpler (Instead of adding another controller and view to the `ToBeWalked` class, I used those that are for the `Dog` class)

## FILE STRUCTURE
The files that I added are (All other files are Silex files):
* app/app.php: just to initiate the application
* app/controllers.php: it includes all the URI routes and the controller methods. 4 routes were defined.
* models/Dog.php: this is where most of the work is done. It uses the Factory design pattern to instantiate objects of the right dog breeds.
* models/Chihuahua.php: a subclass for the class Dog. It adds the attributes "hasStraightEars" and "lastTimeDogWasPetted". It adds the method: "isExcited". It adds the action (method) "pet" and remove the action "walk" (because apparently, we don't walk Chihuahuas)
* models/Bernese.php: a subclass for the class Dog. It adds the attributes "likeToBeGroomed" and "tailColor". It adds the actions (methods) "playWith" and "sleepWithAsCushion"
* models/ToBeWalked.php: the relationship between ToBeWalked and Dog is defined earlier in this README file
* data/data.php: it simply tries to simulate a database
* locale/Captions.php: in order not to include any output text in the controllers or models (since all text should be in the view files), I added all the captions as constants in a class
* templates/*.html: includes the view files for the different actions
* templates/breeds/*.html: includes the additional details that Chihuahuas and Berneses have
* test/*: all the PHP unit tests
