INSTALLATION:
1. Clone repository from GitHub
2. Import database.sql from doc folder
3. Create app/database.php file with your database conditionals (copy content from database.php.default)
4. Create app/bootstrap.php file (copy content from bootstrap.php.default)
5. Create app/core.php file (copy content from core.php.default)

LOGIN DETAILS:
admin user
user: demo1234@example.com
pass: demo1234

TASK:
- you can use our demo cakephp application
- you need to create a plugin (https://book.cakephp.org/2/en/plugins.html) that will use formio (https://github.com/formio/formio.js/):
- the plugin should use its own model (ex. forms, formdates,formrevisions)
- the plugin should allow creating forms with revision (admin needs an option to restore a history version of his created form) 
- the plugin should allow filling/viewing/editing in data to the created forms
- the plugin should allow displaying the data from the completed forms


