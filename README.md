# Student Names
Michael Glanzmann  
Blue Shojinaga
Jake Lipinski
Kassandra Williams
Alia Carmicheal 
Evan Darnell

# Whiskey Valor Foundation Event Management Project

## Purpose
This project is the result of a semester's worth of collaboration among UMW students. The goal of the project was to create a web application that better suits the needs of the Whiskey Valor Foundation, specifically as a system to manage events and community outreach. The system allows users to: sign-up for, and apply for events and retreats; view their registered events; and suggest further collaborations. This system allows administrators to: create events and retreats; manage the information of registered users; create, schedule, and send emails to their users.

## Authors
The ODHS Medicine Tracker is based on an old open source project named "Homebase". [Homebase](https://a.link.will.go.here/) was originally developed for the Ronald McDonald Houses in Maine and Rhode Island by Oliver Radwan, Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker.

Modifications to the original Homebase code were made by the Fall 2022 semester's group of students. That team consisted of Jeremy Buechler, Rebecca Daniel, Luke Gentry, Christopher Herriott, Ryan Persinger, and Jennifer Wells.

A major overhaul to the existing system took place during the Spring 2023 semester, throwing out and restructuring many of the existing database tables. Very little original Homebase code remains. This team consisted of Lauren Knight, Zack Burnley, Matt Nguyen, Rishi Shankar, Alip Yalikun, and Tamra Arant. Every page and feature of the app was changed by this team.

The Gwyneth's Gifts VMS code was modified in the Fall of 2023, revamping the code into the present ODHS Medicine Tracker code. Many of the existing database tables were reused, and many other tables were added. Some portions of the software's functionality were reused from the Gwyneth's Gifts VMS code. Other functions were created to fill the needs of the ODHS Medicine Tracker. The team that made these modifications and changes consisted of Garrett Moore, Artis Hart, Riley Tugeau, Julia Barnes, Ryan Warren, and Collin Rugless.

The ODHS Medicine Tracker code was modified in the Fall of 2024, changing the code to the present Step VA Volunteer Management System code. Many existing database tables were reused or renamed, and some others were added. Some files and portions of the software's functionality were reused from ODHS Medicine Tracker, while other functions were created to fill the needs of Step VA Volunteer Management. The team which made changes and new addtions consisted of Ava Donley, Thomas Held, Madison McCarty, Noah Stafford, Jayden Wynes, Gary Young, and Imaad Qureshi.

In Spring 2025, the Step VA Volunteer Management code was adapted to develop the Fredericksburg SCPA Volunteer Management Web Application. Numerous existing database tables were retained with modifications or renamed, while new tables were introduced as needed. Certain files and functionalities from the original system were integrated, while additional features were designed specifically for the Fredericksburg SCPA Volunteer Management system. The team responsible for these updates and enhancements included Yalda Alemy, Luke Blair, Madison Van Buren, Sean Foley, Luke Gibson, Aiden Meyer, and Israel Ortiz.

In Fall 2025 the codebase for Fredericksburg SCPA Volunteer Management codebase was adapted to serve the uses of the Whiskey Valor Foundation. certain files and functionalities of the original project, predominantly for the foundation of the backend, has been incorporated and integrated into the Whiskey Valor Foundation Event Management Project. The team responsible for this adaptation are: Michael Glanzmann, Blue Shojinaga, Evan Darnell, Jake Lipinski, Kassandra Williams, and Alia Carmicheal 

## User Types
There are three of users (also referred to as 'roles') within Whiskey Valor Foundation Project(WVFP).
* Unregistered Users
* Registered Users
* Admins

Admins can create and edit events, view and approve retreat applications, create and send emails, view suggestions, and verify submitted IDs.

Volunteers can create and edit their profile, sign up for events, submit suggestions, and submit IDs. Volunteer accounts can be archived by the Admin if the account is no longer in use or deleted outright.

There is also a root admin account with username 'vmsroot'. The default password for this account is 'vmsroot'. This account has hardcoded Admin privileges. It is crucial that this account be given a strong password and that the password be easily remembered, as it cannot easily be reset. This account should be used for system administration purposes only.

## Features
Below is an in-depth list of features that were implemented within the system
* User registration and log in
* Dashboard
* Volunteer Management
  * Change own password
  * View verified Identifications
  * Modify profile
  * Reset password
  * User Search
  * Submit Identification
  * Verify Identification
* Events and Event Management
  * Calendar with event listings
  * Calendar day view with event listings
  * Event search
  * Event details page
  * Volunteer event sign up
  * View Upcoming Events
  * View users who are registered to go to an event.
  * Modify event details
  * Create new event
  * Delete event
  * Complete event
  * Apply for retreat
  * Deny retreat application
  * Approve retreat application
  * Flag retreat application
* Reports (print-friendly)
  * No-show totals for events
* Notification system, with notifications generated when
  * A volunteer has requested sign-up
* Email Management
  * Create Email
  * Save Email as a Draft
  * Send Email to individual
  * Send Email to Organization
  * Schedule Email to send
* Suggestions
 * Submitt suggestions
 * View suggestions
* 

## Design Documentation
Several types of diagrams describing the design of the WVFP, including sequence diagrams and use case diagrams, are available. Please contact Dr. Polack for access.

## "localhost" Installation
Below are the steps required to run the project on your local machine for development and/or testing purposes.
1. [Download and install XAMPP](https://www.apachefriends.org/download.html)
2. Open a terminal/command prompt and change directory to your XAMPP install's htdocs folder
  * For Mac, the htdocs path is `/Applications/XAMPP/xamppfiles/htdocs`
  * For Ubuntu, the htdocs path is `/opt/lampp/htdocs/`
  * For Windows, the htdocs path is `C:\xampp\htdocs`
3. Clone the WVFP repo by running the following command: 'https://github.com/jtshojinaga/whiskey-valor'
4. Start the XAMPP MySQL server and Apache server
5. Open the PHPMyAdmin console by navigating to [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/)
6. Create a new database named `whiskeydb`. With the database created, navigate to it by clicking on it in the lefthand pane
7. Import the `whiskeydb.sql` file located in `whiskey-valor/sql` into this new database
8. Create a new user by navigating to `Privileges -> New -> Add user account`
9. Enter the following credentials for the new user:
  * Name: `whiskeydb`
  * Hostname: `Local`
  * Password: `whiskeydb`
  * Leave everything else untouched
10. Navigate to [http://localhost/whiskey-valor/](http://localhost/whiskey-valor/) 
11. Log into the root user account using the username `vmsroot` with password `vmsroot`

Installation is now complete.

## Reset root user credentials
In the event of being locked out of the root user, the following steps will allow resetting the root user's login credentials:
1. Using the PHPMyAdmin console, delete the `vmsroot` user row from the `dbPersons` table
2. Clear the SiteGround dynamic cache [using the steps outlined below](#clearing-the-siteground-cache)
3. Navigate to gwyneth/insertAdmin.php. You should see a message that says `ROOT USER CREATION SUCCESS`
4. You may now log in with the username and password `vmsroot`

## Platform
Dr. Polack chose SiteGrounds as the platform on which to host the project. Below are some guides on how to manage the live project.

### SiteGround Dashboard
Access to the SiteGround Dashboard requires a SiteGround account with access. Access is managed by Dr. Polack.

### Localhost to Siteground
Follow these steps to transfter your localhost version of the Step VA code to Siteground. For a video tutorial on how to complete these steps, contact Dr. Polack.
1. Create an FTP Account on Siteground, giving you the necessary FTP credentials. (Hostname, Username, Password, Port)
2. Use FTP File Transfer Software (Filezilla, etc.) to transfer the files from your localhost folders to your siteground folders using the FTP credentials from step 1.
3. Create the following database-related credentials on Siteground under the MySQL tab:
  - Database - Create the database for the siteground version under the Databases tab in the MySQL Manager by selecting the 'Create Database' button. Database name is auto-generated and can be changed if you like.
  - User - Create a user for the database by either selecting the 'Create User' button under the Users tab, or by selecting the 'Add New User' button from the newly created database under the Databases tab. User name is auto-generated and can be changed  if you like.
  - Password - Created when user is created. Password is auto generated and can be changed if you like.
4. Access the newly created database by navigating to the PHPMyAdmin tab and selecting the 'Access PHPMyAdmin' button. This will redirect you to the PHPMyAdmin page for the database you just created. Navigate to the new database by selecting it from the database list on the left side of the page.
5. Select the 'Import' option from the database options at the top of the page. Select the 'Choose File' button and import the "vms.sql" file from your software files.
  - Ensure that you're keeping your .sql file up to date in order to reduce errors in your Siteground code. Keep in mind that Siteground is case-sensitive, and your database names in the Siteground files must be identical to the database names in the database.
6. Navigate to the 'dbInfo.php' page in your Siteground files. Inside the connect() function, you will see a series of PHP variables. ($host, $database, $user, $pass) Change the server name in the 'if' statement to the name of your server, and change the $database, $user, and $pass variables to the database name, user name, and password that you created in step 3. 

### Setting up cron jobs
The scheduled emails functionality utilizes chron jobs to run a PHP Files at specific intervals. To set up this cron job on Siteground you 
1. Navigate to your website's "SITE TOOLS" from your Siteground websites page.
2. Click on the 'Devs' button on the left side.
3. Click 'Cron Jobs'.
4. Enter the following into the 'Command' section:"php /home/customer/www/jenniferp217.sg-host.com/public_html/scheduledSend.php"
5. Click the interval dropdown and select "Twice Per Day (0 0,12 * * *)"
6. Finish by clicking 'CREATE'




### Clearing the SiteGround cache
#### Chrome
1. Open Chrome and click on the three-dot menu icon in the top-right corner.
2. Navigate to **More Tools** > **Clear Browsing Data**.
3. In the pop-up window:
   - Select the **Time Range** (e.g., "Last 24 hours" or "All time").
   - Check the box for **Cached images and files**.
4. Click **Clear Data**.

#### Safari
1. Open Safari and click on **Safari** in the menu bar at the top of the screen.
2. Select **Preferences** > **Privacy**.
3. Click the **Manage Website Data** button.
4. In the pop-up window, click **Remove All**, then confirm by selecting **Remove Now**.

Clearing your cache will help ensure that you're seeing the latest updates to the application. If you continue experiencing issues, consider reaching out for further support.

### External Libraries and APIs
The only outside library utilized by the WVFP is the jQuery library. The version of jQuery used by the system is stored locally within the repo, within the lib folder. jQuery was used to implement form validation and the hiding/showing of certain page elements. Additionally, the Font Awesome library was used for some of the icon pictures. This library is linked in the headers of some files "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css".


## License
The project remains under the [GNU General Public License v3.0](https://www.gnu.org/licenses/gpl.txt).

