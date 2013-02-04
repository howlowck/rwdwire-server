# Base App
## Features
- Controllers Match Views action to file
- MY_Controller enabled app-level variables
- Gen_Lib enabled misc app-level methods.
- Ldap authentication
- user-role authorization (authority spark)
- ORM abstraction (datamapper spark)
- public assets separated by css, js, vendors
- generator spark (work in progress)

## Get Started:
### Step 0: Setup Database
1. Create a database 
2. Change the "database.php-sample" in application/config to "database.php"

### Step 1: Change Configuration-level Application Name
1. Change Directory name to Application Name
	Ex. ``baseApp`` to ``realApp`` (``realApp`` would be the Application Name)
2. Change file .htaccess-sample in your root directory to .htaccess
3. search for "baseApp" in .htaccess and change it to Application Name

### Step 2: Change Application-level Application Name
1. Change the ``$app_name`` variable in ``application/core/MY_Controller.php``
Hint: This doesn't have to be the same as the name you changed to in Step 1.

### Step 3: Remove .git folder
1.  Remove the .git folder located at the root of your application
Hint:  You might have to enabled "show hidden folders" in your OS settings.

### Step 4: Create Database via migration
1.  Open up your terminal or cmd and navigate to your root directory
2.  Type ``php index.php db migrate``
3.  You should see something like ``Database has been successfully migrated``

### Step 5: Set up your email credential
1.  it's in ``application/config/email.php-sample``
2.  rename ``email.php-sample`` to ``email.php``

### Step 6: Set up reCaptcha Credientials
1.  rename ``application/config/recaptcha.php``
2.  input your private and public keys

### Step 7: Run your application
1.  If the app works, Disco.


