Online Days-Off Manager Portal
------------

This application is a tool, via which the days-off requests in a company can be 
processed in a centralized way, saving time for the employees and the managers.

It's a web site in php 7.1 with mysql database, which can be integrated in the local network
of a company as well as be deployed in a website for external use.



Getting Started
------------

Copy the files in your repository (e.g. xampp, wamp), run the sql script to create the database and your first
administrator and the website will be up and running. For the mail component, there needs to
be some configuration, based on the application running, for it to permit the mail exchange.


System Guide - for users
------------

The user has to log in via the login.php page. e.g. if the webpage is deployed in
a folder name "days-off-portal" in the xampp directory, the user can access it
in localhost/days-off-portal/login.php link

He/she enters his/her credentials (email, password given by managing administrator)
and, if being an employee, he/she gets in a webpage where
all his/her previous requests are shown. There is also the option of submitting 
a new request by pressing the corresponding button (top and right side in the page),
where he/she has to fill in the details regarding his/her request:
dates of request (required) and reason (optional).

If he/she is an admin, then after login, a list of all the users is shown, 
where every one of them can be edited by pressing the "edit" button next to each line.
The admin can also create a new user, by pressing the corresponding button
in his/her homepage; he/she is redirected in a form page, where some details of the
new user must be given: first and last name, email that works as the user's identification,
password(x2) and user's type (employee, administrator).

When a user submits a request, his/her administrator will receive a message with 
the details of the request (dates, reason) and 2 links, an approval and a rejection one.
After the administrator selects his/her action, the user receives a message of the
progress of his/her request (approved or rejected).

In every page, the user and the admin are able to sign out.


System Guide - for developers
------------

The homepage is the login.php page, where the user fills in his/her credentials (email, password).
The passwords are encrypted, in order not to appear in the database in their 
original form, for security reasons. After the user is correctly identified, 
he/she enters in his/her homepage (*welcome.php*).

Depending on the user's type (employee or admin), the user is redirected to a different page
(admin/welcome.php for the administrator, employee/welcome.php for the simple users).


#### **Administrator's Perspective**
The first user with his/her credentials (admin type) must be created in the database.
After the login, the admin is redirected to the admin/welcome.php page, where all the users
appear, with their names, mail and type (admin/employee).

When the admin presses the Create User button, he/she is redirected to a php form (*admin/create_user.php*).
The admin fills in all the requested data. If not all data is received or valid,
he/she is reprompted to give the correct data. The new user is associated to this
specific admin user-manager (admin_email), since in a big company there may be many admins and
not all of them are responsible for each employee.

After the new user is created, he/she appears in the list of all users. The admin can also edit
each user's data, by pressing the Edit button next to each record and redirecting to *admin/edit_user.php?user_id=users_email*
with the user's data filled in.
This time the password is not required, since it is encrypted in the database, for security reasons, and should not be included in the html content.
If the admin changes it, the same rules as with the creation of the user apply.

The *admin/app_validation.php* is a script that depending on the GET attributes (application_id as id, 
status based on which link was selected: approval/rejection) it saves the status of the request and sends a message to the user. 


#### **User's Perspective**
The user gets all post applications by date of submision order (sql querry) 
and can create a new request. If pressing the "Submit Request" button, 
he/she is redirected to a form page (*employee/submit_request.php*). After completing all the details
needed, the data are evaluated in *employee/submit_request_check.php* and if valid,
the user is redirected to homepage, with the new request submitted; if invalid, the user 
is redirected to *employee/submit_request.php* with an error message, prompting him/her to 
fill in valid date (e.g. not in the past or null). The user can also return to homepage
without adding any data, by pressing the Cancel button.

If the request is valid the user's administrator receives a message (in his admin_email)
with the details of the request and the options of approving/rejecting it. If the mail is
successfully sent, the application is stored in the database (with status: pending). Based on which link is selected
by the admin (through mail, following a link to *admin/app_validation.php*), 
the database is updated and the employee receives a message of his/her request's progress.
After that the request in user's past applications is updated with current status (approved/rejected).



Future Work
------------
There are some ideas for improvements:

1. The employees-users should change their passwords if they want, for sequrity reasons. It would also be good 
if each user could change his/her data (e.g. he/she changed email address) and 
not expect from the administrator to do it on behalf of them.

2. The administrators-users should also be able to view the post applications of the users.

3. The administrators probably are emplyees, too, so it may be useful to also have
the ability to request for days off via this system. 


